@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Jam Kerja']]" />

        <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Manajemen Jam Kerja</h2>
            <p class="text-gray-600">Atur jam operasional toko Anda untuk setiap hari dalam seminggu.</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6" x-data="{
            showEditModal: false,
            editForm: {
                id: null,
                day_of_week: '',
                start_time: '',
                end_time: '',
                is_closed: false,
            },
            // Fungsi untuk membuka modal dan mengisi data
            openEditModal(workingHour) {
                this.editForm.id = workingHour.id;
                this.editForm.day_of_week = workingHour.day_of_week;
                this.editForm.start_time = workingHour.start_time;
                this.editForm.end_time = workingHour.end_time;
                this.editForm.is_closed = workingHour.is_closed;
                this.showEditModal = true;
            },
            // Fungsi untuk menutup modal
            closeEditModal() {
                this.showEditModal = false;
                // Reset form data
                this.editForm = {
                    id: null,
                    day_of_week: '',
                    start_time: '',
                    end_time: '',
                    is_closed: false,
                };
            }
        }">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam
                                Mulai</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam
                                Selesai</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($workingHours as $hour)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $hour->day_of_week }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $hour->is_closed ? '-' : ($hour->start_time ? substr($hour->start_time, 0, 5) : '-') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $hour->is_closed ? '-' : ($hour->end_time ? substr($hour->end_time, 0, 5) : '-') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $hour->is_closed ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $hour->is_closed ? 'Tutup' : 'Buka' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button"
                                        @click="openEditModal({{ json_encode([
                                            'id' => $hour->id,
                                            'day_of_week' => $hour->day_of_week,
                                            'start_time' => $hour->start_time ? substr($hour->start_time, 0, 5) : '',
                                            'end_time' => $hour->end_time ? substr($hour->end_time, 0, 5) : '',
                                            'is_closed' => (bool) $hour->is_closed,
                                        ]) }})"
                                        class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada jam kerja ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Edit Modal for Working Hours --}}
            <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    {{-- Overlay --}}
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    {{-- This element is to trick the browser into centering the modal contents. --}}
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form :action="'{{ route('working-hour.update', '') }}/' + editForm.id" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Edit Jam Kerja: <span x-text="editForm.day_of_week"></span>
                                        </h3>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center space-x-3">
                                                <label for="edit_start_time"
                                                    class="block text-sm font-medium text-gray-700 w-24">Jam Mulai</label>
                                                <input type="time" name="start_time" id="edit_start_time"
                                                    x-model="editForm.start_time" :disabled="editForm.is_closed"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <label for="edit_end_time"
                                                    class="block text-sm font-medium text-gray-700 w-24">Jam Selesai</label>
                                                <input type="time" name="end_time" id="edit_end_time"
                                                    x-model="editForm.end_time" :disabled="editForm.is_closed"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                            </div>
                                            <div class="flex items-center">
                                                <input type="hidden" name="is_closed" value="0">
                                                <input type="checkbox" name="is_closed" id="edit_is_closed"
                                                    x-model="editForm.is_closed" value="1"
                                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                                <label for="edit_is_closed" class="ml-2 block text-sm text-gray-900">
                                                    Tutup Sepanjang Hari
                                                </label>
                                            </div>
                                            {{-- Display validation errors from backend --}}
                                            @if ($errors->any())
                                                <div class="text-red-600 text-sm">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="closeEditModal()"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
