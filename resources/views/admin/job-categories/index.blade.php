<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Karir (Kategori & Link G-Form)') }}
        </h2>
    </x-slot>

    {{-- MENGGUNAKAN TATA LETAK VERTIKAL (STACKED) --}}
    <div class="py-6 sm:py-8">
        {{-- Menggunakan max-w-4xl agar tabel tidak terlalu lebar --}}
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Tampilkan Pesan Sukses Global --}}
            @if (session('success_gform'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                    {{ session('success_gform') }}
                </div>
            @endif
            @if (session('success_category'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                    {{ session('success_category') }}
                </div>
            @endif

            {{-- KARTU 1: FORM LINK G-FORM (Compact) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <form method="POST" action="{{ route('admin.careers.updateGform') }}">
                    @csrf
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2 dark:border-gray-700">
                            <i class="bi bi-link-45deg me-2 text-indigo-500"></i>Link Google Form
                        </h3>

                        {{-- Area Pratinjau Link --}}
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Link G-Form saat ini:</p>
                            @if ($gformSetting->value)
                                <a href="{{ $gformSetting->value }}" target="_blank" class="text-sm font-mono text-indigo-600 dark:text-indigo-400 break-all hover:underline">
                                    {{ $gformSetting->value }}
                                </a>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada link G-Form.</p>
                            @endif
                        </div>
                        
                        {{-- Input URL --}}
                        <div>
                            <x-input-label for="url" :value="__('Ganti Link G-Form')" />
                            <x-text-input id="url" class="block mt-1 w-full font-mono" type="url" name="url" :value="old('url', $gformSetting->value)" required />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                        </div>
                    </div>
                    
                    {{-- Footer Aksi --}}
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <x-primary-button class="w-full justify-center bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                            <i class="bi bi-save me-2"></i> {{ __('Simpan Link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            {{-- KARTU 2: DAFTAR KATEGORI PEKERJAAN (CRUD) --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold">Kategori Pekerjaan</h3>
                        <a href="{{ route('admin.job-categories.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                            <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
                        </a>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Slug</th>
                                    <th scope="col" class="px-6 py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($jobCategories as $category)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name }}</th>
                                    <td class="px-6 py-4 font-mono text-xs">{{ $category->slug }}</td>
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        
                                        {{-- PERBAIKAN BUG: Gunakan ['pengaturan_karir' => $category] --}}
                                        <a href="{{ route('admin.job-categories.edit', ['pengaturan_karir' => $category]) }}" title="Edit Kategori" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        
                                        {{-- PERBAIKAN BUG: Gunakan ['pengaturan_karir' => $category] --}}
                                        <form action="{{ route('admin.job-categories.destroy', ['pengaturan_karir' => $category]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini? Lowongan terkait akan ikut terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Kategori" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">Belum ada Kategori Pekerjaan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 flex justify-end">
                        {{ $jobCategories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>