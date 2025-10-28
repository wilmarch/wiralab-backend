<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Link E-Katalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Tampilkan Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                {{-- Form ini akan dikirim ke method 'update' --}}
                <form method="POST" action="{{ route('admin.ekatalog.update') }}">
                    @csrf
                    
                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                        <h3 class="text-xl font-bold mb-2">Edit Link E-Katalog</h3>
                        <p class="mb-4 text-gray-600 dark:text-gray-400">
                            Link ini akan digunakan untuk tombol E-Katalog di website publik (React).
                        </p>
                        
                        {{-- Input URL --}}
                        <div class="mb-4">
                            <x-input-label for="url" :value="__('URL E-Katalog')" />
                            {{-- Tampilkan nilai dari database ($setting->value) --}}
                            <x-text-input id="url" class="block mt-1 w-full font-mono" type="url" name="url" :value="old('url', $setting->value)" required />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                        </div>

                    </div>

                    {{-- Footer Aksi --}}
                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-xl">
                        <x-primary-button class="bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>