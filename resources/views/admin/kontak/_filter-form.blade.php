<div class="mb-6 bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
    <form action="{{ route('admin.kontak.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4 md:items-end">
        
        {{-- Search Bar --}}
        <div class="flex-grow">
            <x-input-label for="search" :value="__('Cari (Nama, Email, Subjek)')" />
            <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" :value="request('search')" placeholder="Ketik nama, email, atau subjek..."/>
        </div>

        {{-- Filter Status --}}
        <div class="flex-grow">
            <x-input-label for="is_read" :value="__('Filter Status')" />
            <select name="is_read" id="is_read" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                <option value="">Semua Status</option>
                <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Baru (Belum Dibaca)</option>
                <option value="1" {{ request('is_read') == '1' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
        </div>
        
        {{-- Tombol --}}
        <div class="flex-shrink-0 flex items-center space-x-2">
            <x-primary-button class="w-full justify-center md:w-auto">
                <i class="bi bi-search me-2"></i> Terapkan
            </x-primary-button>
            <a href="{{ route('admin.kontak.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300">
                Reset
            </a>
        </div>

    </form>
</div>