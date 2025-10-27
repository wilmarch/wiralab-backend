<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori: ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form mengarah ke route admin.categories.update --}}
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf 
                        @method('PATCH') {{-- Method spoofing untuk operasi UPDATE --}}

                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Kategori')" />
                            {{-- Gunakan $category->name atau old('name') --}}
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Tipe Kategori (Biasanya di-disable agar tidak diubah jika sudah punya item) --}}
                        <div class="mb-4">
                             <x-input-label for="category_type" :value="__('Tipe Kategori')" />
                             <select name="category_type" id="category_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                 <option value="product" {{ old('category_type', $category->category_type) == 'product' ? 'selected' : '' }}>Produk</option>
                                 <option value="application" {{ old('category_type', $category->category_type) == 'application' ? 'selected' : '' }}>Aplikasi</option>
                             </select>
                             <x-input-error :messages="$errors->get('category_type')" class="mt-2" />
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                                {{ __('Perbarui Kategori') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>