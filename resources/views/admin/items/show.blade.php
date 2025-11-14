<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Item') }}
            </h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.items.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('admin.items.edit', $item->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-md hover:bg-indigo-700">
                    <i class="bi bi-pencil-square me-2"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                {{-- Area Gambar --}}
                @if ($item->image_url)
                    <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700 p-8">
                        <img src="{{ Storage::url($item->image_url) }}" alt="{{ $item->name }}" 
                             class="max-h-80 max-w-sm object-contain rounded-lg">
                    </div>
                @endif

                {{-- Area Judul & Detail --}}
                <div class="p-6 md:p-8">
                    
                    <div class="border-b pb-4 mb-5 dark:border-gray-700">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">NAMA ITEM</dt>
                        <dd class="mt-0.5 text-3xl font-extrabold text-gray-900 dark:text-white">{{ $item->name }}</dd>
                    </div>

                    {{-- List Detail --}}
                    <dl class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- Tipe --}}
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

                        {{-- Kategori --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0 font-medium">{{ $item->category->name ?? 'Tidak Berkategori' }}</dd>
                        </div>

                        {{-- Status Unggulan (BARU) --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Unggulan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($item->is_featured)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <i class="bi bi-star-fill me-1"></i> Ya, Ditampilkan di Beranda
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                        Tidak
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        {{-- Link Inaproc (BARU) --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Link Inaproc/E-Katalog</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($item->inaproc_url)
                                    <a href="{{ $item->inaproc_url }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium break-all">
                                        {{ $item->inaproc_url }} <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 italic">Tidak ada link.</span>
                                @endif
                            </dd>
                        </div>

                        {{-- Link Brosur (BARU) --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Brosur PDF</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($item->brosur_url)
                                    <a href="{{ Storage::url($item->brosur_url) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Download Brosur
                                    </a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 italic">Tidak ada brosur.</span>
                                @endif
                            </dd>
                        </div>

                        {{-- Slug --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug (URL Key)</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-all">{{ $item->slug }}</dd>
                        </div>
                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}

                    {{-- DESKRIPSI LENGKAP (TRIX) --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Deskripsi Lengkap</h4>
                        <div class="trix-output text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            @if ($item->description)
                                {!! clean($item->description) !!}
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada deskripsi lengkap untuk item ini.</p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>