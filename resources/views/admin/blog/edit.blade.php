<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Postingan: ') . $blog->title }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                <form method="POST" action="{{ route('admin.blog.update', $blog) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100 space-y-6">

                        {{-- Judul Postingan --}}
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Postingan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $blog->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        {{-- Tipe Postingan --}}
                        <div class="mb-4">
                             <x-input-label for="post_type" :value="__('Tipe Postingan')" />
                             <select name="post_type" id="post_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                 <option value="artikel" {{ old('post_type', $blog->post_type) == 'artikel' ? 'selected' : '' }}>Artikel</option>
                                 <option value="berita" {{ old('post_type', $blog->post_type) == 'berita' ? 'selected' : '' }}>Berita</option>
                             </select>
                             <x-input-error :messages="$errors->get('post_type')" class="mt-2" />
                        </div>

                        {{-- Konten (TRIX EDITOR) --}}
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Konten')" />
                            <input id="content" type="hidden" name="content" value="{{ old('content', $blog->content) }}">
                            <trix-editor input="content" class="trix-content block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></trix-editor>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        {{-- Gambar Saat Ini --}}
                        @if ($blog->image_url)
                            <div class="mb-4">
                                <x-input-label :value="__('Gambar Saat Ini')" />
                                <img src="{{ Storage::url($blog->image_url) }}" alt="{{ $blog->title }}" class="mt-2 max-w-xs h-auto border rounded-lg shadow-sm">
                            </div>
                        @endif

                        {{-- Upload Gambar Baru --}}
                        <div class="mb-4">
                            <x-input-label for="image_url" :value="__('Ganti Gambar Utama (Opsional)')" />
                            <input id="image_url" name="image_url" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1"/>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengganti gambar.</p>
                            <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                        </div>
                        
                        {{-- Status Publish --}}
                        <div class="block mb-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input id="is_published" name="is_published" type="checkbox" value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Publikasikan Postingan') }}</span>
                            </label>
                        </div>
                        
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end mt-4 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-xl">
                        <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
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
</x-app-layout>