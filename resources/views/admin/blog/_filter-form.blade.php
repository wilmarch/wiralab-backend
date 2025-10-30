<div class="mb-6 bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
    <form action="{{ route('admin.blog.index') }}" method="GET" class="space-y-4">
        
        {{-- Baris Pertama: Search --}}
        <div>
            <x-input-label for="search" :value="__('Cari Judul Postingan')" />
            <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" :value="request('search')" placeholder="Ketik judul..."/>
        </div>

        {{-- Baris Kedua: Filter Dropdown --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Filter Tipe --}}
            <div>
                <x-input-label for="post_type" :value="__('Filter Tipe Postingan')" />
                <select name="post_type" id="post_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="">Semua Tipe</option>
                    <option value="artikel" {{ request('post_type') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="berita" {{ request('post_type') == 'berita' ? 'selected' : '' }}>Berita</option>
                </select>
            </div>

            {{-- Filter Status --}}
            <div>
                <x-input-label for="is_published" :value="__('Filter Status')" />
                <select name="is_published" id="is_published" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_published') == '1' ? 'selected' : '' }}>Published</option>
                    <option value="0" {{ request('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>
        
        {{-- Tombol --}}
        <div class="flex items-center space-x-2 justify-end pt-4 border-t dark:border-gray-600">
            <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300">
                Reset
            </a>
            <x-primary-button class="w-full justify-center md:w-auto">
                <i class="bi bi-search me-2"></i> Terapkan Filter
            </x-primary-button>
        </div>

    </form>
</div>