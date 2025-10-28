<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Pendaftar Pelatihan') }}
            </h2>
            {{-- Tidak ada tombol "Tambah" untuk pendaftar --}}
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Kontainer Tabel Responsif --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse">
                            
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold w-2/5">Pendaftar</th>
                                    <th scope="col" class="px-6 py-3 font-bold w-1/5">Tipe Training</th>
                                    <th scope="col" class="px-6 py-3 font-bold w-1/5">Status</th>
                                    <th scope="col" class="px-6 py-3 font-bold text-right w-1/5">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($registrations as $reg)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $reg->name }}
                                        <p class="text-xs text-gray-500 font-normal mt-1">{{ $reg->institution }}</p>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $reg->training->name ?? 'Tipe Dihapus' }} {{-- Tampilkan Nama Training --}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Badge Status --}}
                                        @if ($reg->is_contacted)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Sudah Dihubungi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-sm">
                                                BARU
                                            </span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        
                                        {{-- Tombol DETAIL (Fokus Utama Aksi) --}}
                                        <a href="{{ route('admin.pendaftar-pelatihan.show', $reg) }}" 
                                           title="Lihat Detail Pendaftar"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition duration-150">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>
                                        
                                        {{-- Tombol Delete Dihilangkan --}}
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white dark:bg-gray-800">
                                     <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                                        Tidak ada data pendaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-8 flex justify-end">
                        {{ $registrations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>