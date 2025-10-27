<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Item Baru (Produk/Aplikasi)') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    
                    {{-- GANTI FORM DENGAN INI UNTUK MENGGUNAKAN VANILLA JS FILTERING --}}
                    {{-- Hapus x-data="{ itemType: '{{ old('type') }}' }" karena kita pakai JS murni --}}
                    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
                        @csrf 

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- KOLOM KIRI --}}
                            <div>
                                {{-- 1. Nama Item --}}
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Nama Item (Produk/Aplikasi)')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                {{-- 2. Part Number (DIHAPUS DARI VIEW INI) --}}

                                {{-- 3. Tipe Item (Penting) --}}
                                <div class="mb-4">
                                     <x-input-label for="type" :value="__('Tipe Item')" />
                                     <select name="type" id="type" 
                                             {{-- Hapus x-model="itemType" --}}
                                             class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                         <option value="">-- Pilih Tipe --</option>
                                         <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Produk</option>
                                         <option value="application" {{ old('type') == 'application' ? 'selected' : '' }}>Aplikasi</option>
                                     </select>
                                     <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                                
                                {{-- 4. Kategori Item (Penting) --}}
                                <div class="mb-4">
                                     <x-input-label for="category_id" :value="__('Kategori')" />
                                     <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                         <option value="">-- Pilih Kategori --</option>
                                         
                                         {{-- Loop Melalui Kategori dari Controller --}}
                                         @foreach ($categories as $category)
                                             <option value="{{ $category->id }}" 
                                                 data-type="{{ $category->category_type }}" {{-- Simpan tipe kategori di atribut data --}}
                                                 {{-- Hapus x-show --}}
                                                 {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                 {{ $category->name }} ({{ ucfirst($category->category_type) }})
                                             </option>
                                         @endforeach
                                         
                                     </select>
                                     <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- KOLOM KANAN --}}
                            <div>
                                {{-- 5. Deskripsi --}}
                                <div class="mb-4">
                                    <x-input-label for="description" :value="__('Deskripsi Item')" />
                                    <textarea id="description" name="description" rows="5" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                                
                                {{-- 6. Gambar Item --}}
                                <div class="mb-4">
                                    <x-input-label for="image_url" :value="__('Gambar Utama')" />
                                    <input id="image_url" name="image_url" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                                    <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                                </div>
                            </div>

                        </div>
                        
                        {{-- Tombol Simpan --}}
                        <div class="flex items-center justify-end mt-6 border-t pt-4">
                            <a href="{{ route('admin.items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button class="ms-3">
                                {{ __('Simpan Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ↓↓↓ SCRIPT VANILLA JS UNTUK FILTERING KATEGORI ↓↓↓ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = categorySelect.querySelectorAll('option');
            const initialSelectedValue = categorySelect.value; // Ambil nilai awal (untuk old data)

            function filterCategories() {
                const selectedType = typeSelect.value;
                let resetCategoryValue = true; // Flag untuk mereset jika kategori lama tidak valid

                // Loop melalui semua opsi kategori dan tentukan visibilitasnya
                categoryOptions.forEach(option => {
                    const optionType = option.getAttribute('data-type');
                    
                    // Tampilkan opsi jika: 1. Tidak ada tipe yang dipilih, 2. Tipe opsi sama dengan tipe yang dipilih, 3. Opsi adalah default/kosong
                    if (!selectedType || optionType === selectedType || !optionType) {
                        option.style.display = ''; 
                    } else {
                        option.style.display = 'none';
                        // Jika opsi yang disembunyikan adalah opsi yang sedang terpilih, kita harus mereset nilai
                        if (option.value === categorySelect.value && option.value !== "") {
                           resetCategoryValue = true;
                        }
                    }
                });
                
                // Jika tipe item berubah dan opsi yang dipilih sebelumnya tidak valid, reset
                if (resetCategoryValue && categorySelect.value !== "") {
                    categorySelect.value = "";
                }
            }

            // Jalankan filter saat Tipe Item diubah
            typeSelect.addEventListener('change', filterCategories);

            // Jalankan filter saat halaman dimuat (untuk kasus old() data)
            filterCategories();
        });
    </script>
    {{-- ↑↑↑ AKHIR SCRIPT VANILLA JS ↑↑↑ --}}
</x-app-layout>