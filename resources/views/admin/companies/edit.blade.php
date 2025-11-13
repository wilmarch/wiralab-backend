<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Perusahaan: ') . $perusahaan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- REVISI: Ukuran card dikecilkan agar lebih compact --}}
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                <form method="POST" action="{{ route('admin.companies.update', $perusahaan) }}" novalidate>
                    @csrf
                    @method('PATCH')
                    
                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                        <div>
                            <x-input-label for="name" :value="__('Nama Perusahaan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $perusahaan->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </a>
                        <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                            {{ __('Simpan Perusahaan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>