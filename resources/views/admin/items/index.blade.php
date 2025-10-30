<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Item (Produk & Aplikasi)') }}
            </h2>
            <a href="{{ route('admin.items.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white uppercase tracking-wider shadow-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-plus-lg me-2"></i> Tambah Item
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 1. PANGGIL FORM FILTER --}}
                    @include('admin.items._filter-form', ['categories' => $categories])

                    {{-- Kontainer Tabel Responsif --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                            
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold w-2/5">Nama Item</th>
                                    <th scope="col" class="px-6 py-3 font-bold w-1/5">Tipe</th>
                                    <th scope="col" class="px-6 py-3 font-bold w-1/5">Kategori</th>
                                    <th scope="col" class="px-6 py-3 font-bold text-right w-1/5">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($items as $item)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $item->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @if ($item->type === 'product')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 shadow-sm">
                                                PRODUK
                                            </span>
                                        @elseif ($item->type === 'application')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 shadow-sm">
                                                APLIKASI
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $item->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        <a href="{{ route('admin.items.show', $item) }}" title="Lihat Detail"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 shadow-sm transition duration-150">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.items.edit', $item) }}" title="Edit Item"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition duration-150">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.items.destroy', $item) }}" 
                                              method="POST" 
                                              class="inline-flex items-center" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    title="Hapus Item"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm transition duration-150">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white dark:bg-gray-800">
                                     <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-base italic">
                                        Tidak ada data item yang cocok dengan filter.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- 2. PAGINATION DENGAN .appends() --}}
                    <div class="mt-8 flex justify-end">
                        {!! $items->appends(request()->query())->links() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>