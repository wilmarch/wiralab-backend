<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Item: ') . $item->name }}
        </h2>
    </x-slot>

    {{-- Asumsi Trix sudah di-load global di app.css/app.js --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                <form method="POST" action="{{ route('admin.items.update', $item->slug) }}" enctype="multipart/form-data" novalidate>
                    @csrf 
                    @method('PATCH')

                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100 space-y-6">

                        {{-- Grid Atas (Info Dasar) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- KOLOM KIRI --}}
                            <div class="space-y-6">
                                {{-- 1. Nama Item --}}
                                <div>
                                    <x-input-label for="name" :value="__('Nama Item (Produk/Aplikasi)')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $item->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                {{-- 2. Tipe Item --}}
                                <div>
                                     <x-input-label for="type" :value="__('Tipe Item')" />
                                     <select name="type" id="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                         <option value="">-- Pilih Tipe --</option>
                                         <option value="product" {{ old('type', $item->type) == 'product' ? 'selected' : '' }}>Produk</option>
                                         <option value="application" {{ old('type', $item->type) == 'application' ? 'selected' : '' }}>Aplikasi</option>
                                     </select>
                                     <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                                
                                {{-- 3. Kategori Item --}}
                                <div>
                                     <x-input-label for="category_id" :value="__('Kategori')" />
                                     <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                         <option value="">-- Pilih Kategori --</option>
                                         @foreach ($categories as $category)
                                             <option value="{{ $category->id }}" 
                                                 data-type="{{ $category->category_type }}"
                                                 {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                 {{ $category->name }} ({{ ucfirst($category->category_type) }})
                                             </option>
                                         @endforeach
                                     </select>
                                     <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- KOLOM KANAN --}}
                            <div class="space-y-6">
                                {{-- 4. Gambar Item --}}
                                <div>
                                    <x-input-label for="image_url" :value="__('Ganti Gambar Utama (Opsional, Max 2MB)')" />
                                    @if ($item->image_url)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($item->image_url) }}" alt="Gambar Lama" class="w-32 h-auto rounded-lg shadow-md bg-gray-100 p-2">
                                        </div>
                                    @endif
                                    <input id="image_url" name="image_url" type="file" accept="image/png, image/jpeg, image/webp"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-2"/>
                                    <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                                </div>

                                {{-- 5. Brosur (BARU) --}}
                                <div>
                                    <x-input-label for="brosur_url" :value="__('Ganti Brosur PDF (Opsional, Max 5MB)')" />
                                    @if ($item->brosur_url)
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($item->brosur_url) }}" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> Lihat Brosur Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    <input id="brosur_url" name="brosur_url" type="file" accept=".pdf"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-2"/>
                                    <x-input-error :messages="$errors->get('brosur_url')" class="mt-2" />
                                </div>

                                {{-- 6. Link Inaproc (BARU) --}}
                                <div>
                                    <x-input-label for="inaproc_url" :value="__('Link Inaproc (Opsional)')" />
                                    <x-text-input id="inaproc_url" class="block mt-1 w-full" type="url" name="inaproc_url" :value="old('inaproc_url', $item->inaproc_url)" placeholder="https://..." />
                                    <x-input-error :messages="$errors->get('inaproc_url')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- 7. Deskripsi (TRIX EDITOR) --}}
                        <div class="mt-6 border-t dark:border-gray-700 pt-6">
                            <x-input-label for="description" :value="__('Deskripsi Item (Wajib Diisi)')" />
                            <input id="description" type="hidden" name="description" value="{{ old('description', $item->description) }}">
                            <trix-editor input="description" class="trix-content block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm"></trix-editor>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        {{-- 8. Produk Unggulan (BARU) --}}
                        <div class="block mt-6 border-t dark:border-gray-700 pt-6">
                            <label for="is_featured" class="inline-flex items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Tandai sebagai Produk Unggulan (Featured)') }}</span>
                            </label>
                        </div>
                        
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex items-center justify-end mt-6 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600 rounded-b-xl">
                        <a href="{{ route('admin.items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </a>
                        <x-primary-button class="ms-3 bg-green-600 hover:bg-green-700 active:bg-green-700 focus:ring-green-500">
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script filtering kategori --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Kode JS Anda tetap sama)
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = categorySelect.querySelectorAll('option');

            function filterCategories() {
                const selectedType = typeSelect.value;
                let categoryFound = false;

                categoryOptions.forEach(option => {
                    const optionType = option.getAttribute('data-type');
                    
                    if (!selectedType || optionType === selectedType || !optionType) {
                        option.style.display = ''; 
                    } else {
                        option.style.display = 'none';
                    }

                    if (option.selected && option.style.display !== 'none') {
                        categoryFound = true;
                    }
                });
                
                if (categorySelect.value !== "" && !categoryFound) {
                    categorySelect.value = "";
                }
            }
            typeSelect.addEventListener('change', filterCategories);
            filterCategories();
        });
    </script>
</x-app-layout>