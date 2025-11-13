<x-app-layout>
    <x-slot name="header">
        {{-- PERBAIKAN: Ganti $lokasi_karir -> $lokasi --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Lokasi Karir: ') . $lokasi->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                {{-- PERBAIKAN: Ganti $lokasi_karir -> $lokasi --}}
                <form method="POST" action="{{ route('admin.locations.update', $lokasi) }}" novalidate>
                    @csrf
                    @method('PATCH')
                    
                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                        <div>
                            <x-input-label for="name" :value="__('Nama Lokasi')" />
                            {{-- PERBAIKAN: Ganti $lokasi_karir -> $lokasi --}}
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $lokasi->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('admin.locations.index') }}" class="...">Batal</a>
                        <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700">
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>