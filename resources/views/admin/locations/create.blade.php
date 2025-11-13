<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Lokasi Karir Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                <form method="POST" action="{{ route('admin.locations.store') }}" novalidate>
                    @csrf
                    
                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                        <div>
                            <x-input-label for="name" :value="__('Nama Lokasi (cth: Jakarta Barat, Surabaya, Remote)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </a>
                        <x-primary-button class="ms-3">
                            {{ __('Simpan Lokasi') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>