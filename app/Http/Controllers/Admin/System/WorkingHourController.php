<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkingHourController extends Controller
{
    /**
     * Display a listing of the working hours.
     */
    // App\Http\Controllers\Admin\WorkingHourController.php
    public function index()
    {
        $dayOrder = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];
        $workingHours = WorkingHour::whereIn('day_of_week', $dayOrder)
            ->get(); // Ini sudah benar, akan mengembalikan koleksi model

        return view('admin.working-hour.index', compact('workingHours'));
    }

    /**
     * Show the form for editing the specified working hour.
     */
    public function edit(WorkingHour $workingHour)
    {
        // Mengembalikan data jam kerja dalam format JSON untuk modal
        return response()->json([
            'id' => $workingHour->id,
            'day_of_week' => $workingHour->day_of_week,
            'start_time' => $workingHour->start_time ? substr($workingHour->start_time, 0, 5) : '', // Format HH:MM
            'end_time' => $workingHour->end_time ? substr($workingHour->end_time, 0, 5) : '', // Format HH:MM
            'is_closed' => (bool) $workingHour->is_closed,
        ]);
    }

    /**
     * Update the specified working hour in storage.
     */
    public function update(Request $request, WorkingHour $workingHour)
    {
        $validatedData = $request->validate([
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time_if_not_closed', // Custom rule for end_time
            'is_closed' => 'boolean',
        ], [
            'start_time.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'end_time.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
            'is_closed.boolean' => 'Status tutup tidak valid.',
        ]);

        // Tambahkan custom validation rule untuk end_time
        // Ini memastikan end_time hanya divalidasi 'after' start_time jika is_closed adalah false
        $request->merge(['start_time_if_not_closed' => $request->input('is_closed') ? null : $request->input('start_time')]);
        $request->validate([
            'end_time' => 'nullable|date_format:H:i|after:start_time_if_not_closed',
        ]);


        DB::beginTransaction();
        try {
            if ($validatedData['is_closed']) {
                $workingHour->update([
                    'start_time' => null,
                    'end_time' => null,
                    'is_closed' => true,
                ]);
            } else {
                $workingHour->update([
                    'start_time' => $validatedData['start_time'],
                    'end_time' => $validatedData['end_time'],
                    'is_closed' => false,
                ]);
            }

            DB::commit();

            SystemLog::log(
                LogLevel::INFO->value,
                'WORKING_HOUR_UPDATED',
                'Jam kerja untuk "' . $workingHour->day_of_week . '" berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'working_hour_id' => $workingHour->id,
                    'day_of_week' => $workingHour->day_of_week,
                    'start_time' => $workingHour->start_time,
                    'end_time' => $workingHour->end_time,
                    'is_closed' => $workingHour->is_closed,
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );

            return redirect()->route('working-hour.index')->with('success', 'Jam kerja berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            SystemLog::log(
                LogLevel::ERROR->value,
                'WORKING_HOUR_UPDATE_FAILED',
                'Gagal memperbarui jam kerja untuk "' . $workingHour->day_of_week . '". Error: ' . $e->getMessage(),
                [
                    'working_hour_id' => $workingHour->id,
                    'request_data' => $request->all(),
                    'error_message' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString(),
                    'user_id' => Auth::id(),
                ]
            );
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jam kerja: ' . $e->getMessage());
        }
    }
}
