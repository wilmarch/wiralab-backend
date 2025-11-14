<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Perusahaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                {{-- Tambahkan enctype untuk upload file --}}
                <form method="POST" action="{{ route('admin.companies.store') }}" novalidate enctype="multipart/form-data">
                    @csrf
                    
                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100 space-y-6">
                        
                        {{-- Nama Perusahaan --}}
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Perusahaan (cth: PT Wiralab Analitika Solusindo)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Logo Perusahaan (BARU) --}}
                        <div class="mb-4">
                            <x-input-label for="logo" :value="__('Logo Perusahaan (Opsional, Max 2MB)')" />
                            <input id="logo" name="logo" type="file" accept="image/png, image/jpeg, image/webp"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </a>
                        <x-primary-button class="ms-3">
                            {{ __('Simpan Perusahaan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>