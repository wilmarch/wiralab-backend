<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Postingan') }}
            </h2>
            {{-- Tombol Aksi di Header Utama --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.blog.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a href="{{ route('admin.blog.edit', $blog) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <i class="bi bi-pencil-square me-2"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        {{-- MENGURANGI LEBAR KONTEN KESELURUHAN MENJADI max-w-3xl --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- KARTU UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                {{-- AREA 1: GAMBAR (DIPUSATKAN DAN LEBARNYA DIKONTROL) --}}
                <div classT="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700 p-6">
                    @if ($blog->image_url)
                        <img src="{{ Storage::url($blog->image_url) }}" alt="{{ $blog->title }}" 
                             {{-- KUNCI PERUBAHAN: Gambar tidak lagi full-width, tapi terpusat --}}
                             class="max-w-lg mx-auto h-auto object-contain rounded-lg shadow-md transition duration-300 hover:opacity-80 cursor-pointer"
                             onclick="window.open(this.src);">
                    @else
                        <div class="w-full h-48 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <i class="bi bi-image-fill text-4xl mb-2"></i> 
                            <span class="text-base font-medium block">Tidak Ada Gambar</span>
                        </div>
                    @endif
                </div>

                {{-- AREA 2: JUDUL & DETAIL UTAMA --}}
                <div class="p-6 md:p-8">
                    
                    {{-- Judul Postingan (Focal Point) --}}
                    <div class="border-b pb-4 mb-5 dark:border-gray-700">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">JUDUL POSTINGAN</dt>
                        <dd class="mt-0.5 text-2xl font-extrabold text-gray-900 dark:text-white">{{ $blog->title }}</dd>
                    </div>

                    {{-- DETAIL INFORMASI (Gaya List Rapat) --}}
                    <dl class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- Tipe --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TIPE</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($blog->post_type === 'berita')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-600 text-white shadow-sm">BERITA</span>
                                @elseif ($blog->post_type === 'artikel')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-600 text-white shadow-sm">ARTIKEL</span>
                                @endif
                            </dd>
                        </div>
                        
                        {{-- Status --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">STATUS</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($blog->is_published)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Published</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">Draft</span>
                                @endif
                            </dd>
                        </div>

                        {{-- Dibuat Pada --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DIBUAT PADA</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $blog->created_at->format('d M Y H:i:s') }}</dd>
                        </div>
                        
                        {{-- Diperbarui Terakhir --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DIPERBARUI PADA</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $blog->updated_at->format('d M Y H:i:s') }}</dd>
                        </div>
                        
                        {{-- Slug --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SLUG (URL KEY)</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 break-all">{{ $blog->slug }}</dd>
                        </div>
                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}

                    {{-- KONTEN LENGKAP --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Konten Lengkap</h4>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            @if ($blog->content)
                                {{-- whitespace-pre-wrap menjaga format paragraf dari textarea --}}
                                <p class="whitespace-pre-wrap">{{ $blog->content }}</p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada konten.</p>
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