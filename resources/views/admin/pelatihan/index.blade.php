<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Pelatihan') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        {{-- Menggunakan max-w-4xl agar tabel Tipe Training tidak terlalu lebar --}}
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8"> {{-- Mengganti grid menjadi space-y-8 --}}
            
            {{-- Tampilkan Pesan Sukses Global (jika ada) --}}
            @if (session('success_pdf'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                    {{ session('success_pdf') }}
                </div>
            @endif
            @if (session('success_training'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                    {{ session('success_training') }}
                </div>
            @endif

            {{-- KARTU 1: UPLOAD PDF (Compact) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2 dark:border-gray-700">
                        <i class="bi bi-file-earmark-pdf-fill me-2 text-red-500"></i>Brosur Pelatihan
                    </h3>

                    {{-- Area Pratinjau File (Compact) --}}
                    <div class="mb-4 p-3 rounded-lg border border-dashed {{ $pdfSetting->value ? 'border-green-400 dark:border-green-600' : 'border-gray-400 dark:border-gray-500' }} bg-gray-50 dark:bg-gray-700 transition duration-300">
                        @if ($pdfSetting->value)
                            <div class="flex items-center space-x-2">
                                <i class="bi bi-file-earmark-check-fill text-2xl text-green-600 dark:text-green-400"></i>
                                <div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-100">File Aktif Tersedia</p>
                                    <a href="{{ Storage::url($pdfSetting->value) }}" target="_blank" 
                                       class="text-xs font-mono text-indigo-600 dark:text-indigo-400 break-all hover:underline"
                                       title="Klik untuk download">
                                        {{ basename($pdfSetting->value) }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-center space-x-2 text-gray-500 dark:text-gray-400">
                                <i class="bi bi-file-earmark-x-fill text-2xl"></i>
                                <span class="text-xs font-medium">Belum ada Brosur PDF di-upload.</span>
                            </div>
                        @endif
                    </div>

                    {{-- Form Upload --}}
                    <form action="{{ route('admin.pelatihan.updatePdf') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-2">
                            <x-input-label for="file_pelatihan" :value="__('Pilih File PDF Baru')" class="text-sm mb-1" />
                            <input id="file_pelatihan" name="file_pelatihan" type="file" accept=".pdf" required
                                   class="block w-full text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300 dark:hover:file:bg-indigo-800 cursor-pointer"/>
                            <x-input-error :messages="$errors->get('file_pelatihan')" class="mt-2" />
                        </div>
                        <x-primary-button class="mt-4 w-full justify-center bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                            <i class="bi bi-upload me-2"></i> {{ __('Upload / Ganti File') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>


            {{-- KARTU 2: DAFTAR TIPE TRAINING (CRUD) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold">Tipe Training (Dropdown)</h3>
                        <a href="{{ route('admin.pelatihan.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                            <i class="bi bi-plus-lg me-2"></i> Tambah Tipe
                        </a>
                    </div>

                    {{-- PANGGIL FORM FILTER --}}
                    @include('admin.pelatihan._filter-form')

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold">Nama Tipe Training</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($trainings as $training)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $training->name }}</th>
                                    <td class="px-6 py-4">
                                        @if ($training->is_active)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                <i class="bi bi-x-circle-fill me-1"></i> Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.pelatihan.edit', $training) }}" title="Edit Tipe" 
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition duration-150">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        
                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('admin.pelatihan.destroy', $training) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus tipe training ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Tipe" 
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm transition duration-150">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">Belum ada tipe training.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 flex justify-end">
                        {!! $trainings->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>