<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Ukuran compact, fokus di tengah --}}
            
            {{-- KARTU UTAMA DETAIL --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                {{-- JUDUL KATEGORI --}}
                <div class="px-6 py-4 md:px-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                        {{ $category->name }}
                    </h3>
                </div>

                {{-- DETAIL INFORMASI (Gaya List Rapat) --}}
                <div class="p-6 md:p-8">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        
                        {{-- Nama Kategori --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $category->name }}</dd>
                        </div>
                        
                        {{-- Tipe Kategori --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($category->category_type === 'product')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-sm">PRODUK</span>
                                @elseif ($category->category_type === 'application')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-600 text-white shadow-sm">APLIKASI</span>
                                @endif
                            </dd>
                        </div>

                        {{-- Slug --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug (URL Key)</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-all">{{ $category->slug }}</dd>
                        </div>
                        
                        {{-- Dibuat Pada --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Pada</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $category->created_at->format('d M Y H:i:s') }}</dd>
                        </div>
                        
                        {{-- Diperbarui Terakhir --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diperbarui Terakhir</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $category->updated_at->format('d M Y H:i:s') }}</dd>
                        </div>

                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}
                    
                </div>

                {{-- FOOTER KARTU: Tombol Aksi --}}
                <div class="px-6 py-4 md:px-8 bg-gray-50 dark:bg-gray-700 flex justify-end gap-3 rounded-b-xl border-t border-gray-200 dark:border-gray-600">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 transition duration-150">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition duration-150">
                        <i class="bi bi-pencil-square me-2"></i> Edit Kategori
                    </a>
                </div>

            </div>
            {{-- AKHIR KARTU UTAMA --}}
        </div>
    </div>
</x-app-layout>