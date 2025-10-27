<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Item') }}
            </h2>
            {{-- Tombol Aksi di Header --}}
            <div class="space-x-2">
                <a href="{{ route('admin.items.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('admin.items.edit', $item->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-pencil-square me-2"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        {{-- Mengurangi max-w menjadi 3xl agar lebih compact di tengah --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- KARTU UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                {{-- AREA 1: GAMBAR (Dibatasi ukurannya) --}}
                <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700 p-8">
                    @if ($item->image_url)
                        {{-- Kunci: Membatasi tinggi (max-h-80) dan lebar (max-w-md) gambar --}}
                        <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}" 
                             class="max-h-80 max-w-sm object-contain rounded-lg transition duration-300 hover:opacity-80 cursor-pointer"
                             onclick="window.open(this.src);">
                    @else
                        <div class="w-full h-48 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-image-fill text-5xl mb-3"></i> 
                            <span class="text-lg font-medium block">Tidak Ada Gambar</span>
                        </div>
                    @endif
                </div>

                {{-- AREA 2: JUDUL & DETAIL UTAMA --}}
                <div class="p-6 md:p-8">
                    
                    {{-- Judul Item --}}
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4 dark:border-gray-700">
                        {{ $item->name }}
                    </h3>

                    {{-- DETAIL INFORMASI (Gaya List/Tabel Ramping) --}}
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- Baris: Nama Item Lengkap (Sama dengan Judul, tapi untuk konsistensi struktur) --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Item Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0 font-medium">{{ $item->name }}</dd>
                        </div>
                        
                        {{-- Baris: Tipe --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($item->type === 'product')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-md">
                                        <i class="bi bi-box-seam me-2"></i> PRODUK
                                    </span>
                                @elseif ($item->type === 'application')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-600 text-white shadow-md">
                                        <i class="bi bi-pc-display-horizontal me-2"></i> APLIKASI
                                    </span>
                                @endif
                            </dd>
                        </div>

                        {{-- Baris: Kategori --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0 font-medium">{{ $item->category->name ?? 'Tidak Berkategori' }}</dd>
                        </div>
                        
                        {{-- Baris: Slug --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug (URL Key)</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-all">{{ $item->slug }}</dd>
                        </div>
                        
                        {{-- Baris: Dibuat/Diperbarui --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat / Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                Dibuat: {{ $item->created_at->format('d M Y H:i') }} <br>
                                Diperbarui: {{ $item->updated_at->format('d M Y H:i') }}
                            </dd>
                        </div>

                    </div>
                    {{-- AKHIR DETAIL INFORMASI --}}

                    {{-- DESKRIPSI LENGKAP --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Deskripsi Lengkap</h4>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            @if ($item->description)
                                <p class="whitespace-pre-wrap">{{ $item->description }}</p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada deskripsi lengkap untuk item ini.</p>
                            @endif
                        </div>
                    </section>
                </div>
                {{-- AKHIR BODY KARTU --}}

            </div>
            {{-- AKHIR KARTU UTAMA --}}
        </div>
    </div>
</x-app-layout>