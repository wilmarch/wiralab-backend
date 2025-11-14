<div class="mb-6 bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
    <form action="{{ route('admin.items.index') }}" method="GET" class="space-y-4">
        
        {{-- Baris Pertama: Search --}}
        <div>
            <x-input-label for="search" :value="__('Cari Nama Item (Produk/Aplikasi)')" />
            <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" :value="request('search')" placeholder="Ketik nama item..."/>
        </div>

        {{-- Baris Kedua: Filter Dropdown --}}
        {{-- REVISI: Ubah 'md:grid-cols-2' menjadi 'md:grid-cols-3' --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            {{-- Filter Tipe --}}
            <div>
                <x-input-label for="type" :value="__('Filter Tipe Item')" />
                <select name="type" id="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="">Semua Tipe</option>
                    <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Produk</option>
                    <option value="application" {{ request('type') == 'application' ? 'selected' : '' }}>Aplikasi</option>
                </select>
            </div>

            {{-- Filter Kategori --}}
            <div>
                <x-input-label for="category_id" :value="__('Filter Kategori')" />
                <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->category_type }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ↓↓↓ TAMBAHKAN DROPDOWN BARU INI ↓↓↓ --}}
            <div>
                <x-input-label for="is_featured" :value="__('Filter Produk Unggulan')" />
                <select name="is_featured" id="is_featured" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Ya (Unggulan)</option>
                    <option value="0" {{ request('is_featured') === '0' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
        </div>
        
        {{-- Tombol --}}
        <div class="flex items-center space-x-2 justify-end pt-4 border-t dark:border-gray-600">
            <a href="{{ route('admin.items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300">
                Reset
            </a>
            <x-primary-button class="w-full justify-center md:w-auto">
                <i class="bi bi-search me-2"></i> Terapkan Filter
            </x-primary-button>
        </div>

    </form>
</div>