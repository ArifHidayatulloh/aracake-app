<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemSettingController extends Controller
{
    private function validateSystemSetting(Request $request, $id = null)
    {
        $rules = [
            'setting_key' => 'required|string|unique:system_settings,setting_key,' . $id,
            'setting_value' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string|in:string,int,decimal,boolean,json', // Tambah 'json' untuk fleksibilitas
            'is_active' => 'nullable|boolean',
        ];

        $messages = [
            'setting_key.required' => 'Kunci pengaturan wajib diisi.',
            'setting_key.unique' => 'Kunci pengaturan sudah ada. Mohon gunakan kunci lain.',
            'setting_value.required' => 'Nilai pengaturan wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'type.required' => 'Tipe pengaturan wajib diisi.',
            'type.in' => 'Tipe pengaturan tidak valid. Mohon gunakan "string", "int", "decimal", "boolean", atau "json".', // Tambah 'json' untuk fleksibilitas
            'is_active.boolean' => 'Status aktif harus berupa boolean.',
        ];

        return $request->validate($rules, $messages);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systemSettings = SystemSetting::all();
        return view('admin.system-setting.index', compact('systemSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.system-setting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateSystemSetting($request);

        try {
            $systemSetting = SystemSetting::create($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'SYSTEM_SETTING_CREATED',
                'Pengaturan sistem "' . $systemSetting->setting_key . '" telah berhasil dibuat oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'setting_id' => $systemSetting->id,
                    'setting_key' => $systemSetting->setting_key,
                    'setting_value' => $systemSetting->setting_value,
                    'created_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.system-setting.index')->with('success', 'Pengaturan sistem berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pengaturan sistem: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemSetting $systemSetting)
    {
        return view('admin.system-setting.edit', compact('systemSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemSetting $systemSetting)
    {
        $validatedData = $this->validateSystemSetting($request, $systemSetting->id);

        try {
            $systemSetting->update($validatedData);

            // ---- Catat Aktivitas ke SystemLog ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'SYSTEM_SETTING_UPDATED',
                'Pengaturan sistem "' . $systemSetting->setting_key . '" telah berhasil diperbarui oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'setting_id' => $systemSetting->id,
                    'setting_key' => $systemSetting->setting_key,
                    'setting_value' => $systemSetting->setting_value,
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- End Log ---- //

            return redirect()->route('admin.system-setting.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengaturan sistem: ' . $e->getMessage());
        }
    }
}
