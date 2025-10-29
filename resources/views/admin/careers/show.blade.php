<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Lowongan Karir') }}
            </h2>
            {{-- Tombol Aksi di Header Utama --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.careers.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('admin.careers.edit', $karir) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-pencil-square me-2"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- KARTU UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                {{-- AREA JUDUL & DETAIL --}}
                <div class="p-5 md:p-6">
                    
                    {{-- Judul Lowongan (Focal Point) --}}
                    <div class="border-b pb-3 mb-4 dark:border-gray-700">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">JUDUL PEKERJAAN</dt>
                        <dd class="mt-0.5 text-2xl font-extrabold text-gray-900 dark:text-white">{{ $karir->title }}</dd>
                    </div>

                    {{-- DETAIL INFORMASI (Gaya List Rapat) --}}
                    <dl class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- Kategori --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">KATEGORI</dt>
                            <dd class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 sm:col-span-2 sm:mt-0">
                                {{ $karir->jobCategory->name ?? 'N/A' }}
                            </dd>
                        </div>
                        
                        {{-- Status --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">STATUS</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($karir->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Aktif (Ditampilkan)</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">Non-Aktif (Disembunyikan)</span>
                                @endif
                            </dd>
                        </div>

                        {{-- Batas Lamar --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">BATAS LAMAR</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{ $karir->closing_date ? $karir->closing_date->format('d M Y') : 'Tidak Ditentukan' }}
                            </dd>
                        </div>
                        
                        {{-- Slug --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SLUG (URL KEY)</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-all">{{ $karir->slug }}</dd>
                        </div>
                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}

                    {{-- DESKRIPSI --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Deskripsi Pekerjaan</h4>
                        
                        {{-- KODE DIRAPIKAN: Kelas .trix-output digabung dengan kontainer --}}
                        <div class="trix-output text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            @if ($karir->description)
                                {!! clean($karir->description) !!}
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada deskripsi.</p>
                            @endif
                        </div>
                    </section>
                    
                    {{-- PERSYARATAN --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Persyaratan</h4>

                        {{-- KODE DIRAPIKAN: Kelas .trix-output digabung dengan kontainer --}}
                        <div class="trix-output text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            @if ($karir->requirements)
                                {!! clean($karir->requirements) !!}
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada persyaratan.</p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>