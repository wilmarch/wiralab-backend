<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pesan Masuk (Kontak)') }}
            </h2>
            {{-- Tidak ada tombol "Tambah" untuk pesan masuk --}}
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Pesan Sukses (Jika nanti ada aksi update status, dll) --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Kontainer Tabel Responsif --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                            
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">Pengirim</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Subjek</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Status</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Diterima</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($messages as $message)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $message->name }}
                                        <p class="text-xs text-gray-500 font-normal mt-1">{{ $message->email }}</p>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $message->subject ?? '(Tanpa Subjek)' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Badge Status --}}
                                        @if ($message->is_read)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                Sudah Dibaca
                                            </span>
                                        @else
                                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-sm">
                                                BARU
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        {{ $message->created_at->diffForHumans() }}
                                    </td>
                                    
                                    {{-- Kolom Aksi (Hanya Tombol Detail) --}}
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        
                                        {{-- Tombol DETAIL --}}
                                        <a href="{{ route('admin.kontak.show', $message) }}" 
                                           title="Lihat Pesan"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 shadow-sm transition duration-150">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>
                                        
                                        {{-- Tombol Delete Dihapus --}}
                                        
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white dark:bg-gray-800">
                                     <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-base italic">
                                        Tidak ada pesan masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-8 flex justify-end">
                        {{ $messages->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>