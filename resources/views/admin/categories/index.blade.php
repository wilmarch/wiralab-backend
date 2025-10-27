<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Kategori') }}
            </h2>
            {{-- Tombol Tambah Kategori --}}
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white uppercase tracking-wider shadow-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Kontainer Utama: Card --}}
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
                            
                            {{-- Header Tabel --}}
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/3">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/4">Tipe</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/4">Slug (URL)</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/5">Aksi</th> 
                                </tr>
                            </thead>
                            
                            {{-- Body Tabel --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($categories as $category)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $category->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{-- Tampilkan Tipe Kategori dengan Badge/Label --}}
                                        @if ($category->category_type === 'product')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 shadow-sm">
                                                <i class="bi bi-box-seam me-1"></i> PRODUK
                                            </span>
                                        @elseif ($category->category_type === 'application')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 shadow-sm">
                                                <i class="bi bi-app-indicator me-1"></i> APLIKASI
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono text-gray-500 dark:text-gray-400">
                                        {{ $category->slug }}
                                    </td>
                                    
                                    {{-- Kolom Aksi (Tambah Detail Button) --}}
                                    <td class="px-6 py-4 flex justify-end space-x-2"> 
                                        
                                        {{-- Tombol DETAIL (Baru Ditambahkan) --}}
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           title="Lihat Detail"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 shadow-sm transition duration-150">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           title="Edit Kategori"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition duration-150">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        
                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="inline-flex items-center" 
                                              onsubmit="return confirm('PERINGATAN: Menghapus kategori ini akan menghapus SEMUA ITEM yang terasosiasi. Yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    title="Hapus Kategori"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm transition duration-150">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white dark:bg-gray-800">
                                     <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-base italic">
                                        Belum ada data kategori. Silakan klik "Tambah Kategori" di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-8 flex justify-end">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>