<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Lowongan Karir: ') . $karir->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                {{-- Form mengarah ke route update, method PATCH --}}
                <form method="POST" action="{{ route('admin.careers.update', $karir) }}">
                    @csrf
                    @method('PATCH') {{-- Method spoofing untuk UPDATE --}}

                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100 space-y-6">

                        {{-- Judul Pekerjaan --}}
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Pekerjaan')" />
                            {{-- Menggunakan data lama: old('title', $karir->title) --}}
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $karir->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Grid 2 Kolom untuk Kategori & Batas Lamar --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kategori Pekerjaan --}}
                            <div class="mb-4">
                                 <x-input-label for="job_category_id" :value="__('Kategori Pekerjaan')" />
                                 <select name="job_category_id" id="job_category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                     <option value="">-- Pilih Kategori --</option>
                                     @foreach ($jobCategories as $category)
                                         {{-- Menggunakan data lama: old('job_category_id', $karir->job_category_id) --}}
                                         <option value="{{ $category->id }}" {{ old('job_category_id', $karir->job_category_id) == $category->id ? 'selected' : '' }}>
                                             {{ $category->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                 <x-input-error :messages="$errors->get('job_category_id')" class="mt-2" />
                            </div>

                            {{-- Batas Lamar --}}
                            <div class="mb-4">
                                <x-input-label for="closing_date" :value="__('Batas Tanggal Lamar')" />
                                {{-- Menggunakan data lama: old('closing_date', $karir->closing_date->format('Y-m-d')) --}}
                                <x-text-input id="closing_date" class="block mt-1 w-full" type="date" name="closing_date" 
                                              :value="old('closing_date', $karir->closing_date ? $karir->closing_date->format('Y-m-d') : '')" 
                                              required min="{{ $minDate }}" />
                                <x-input-error :messages="$errors->get('closing_date')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi Pekerjaan')" />
                            {{-- Menggunakan data lama: old('description', $karir->description) --}}
                            <textarea id="description" name="description" rows="10" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $karir->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Persyaratan --}}
                        <div class="mb-4">
                            <x-input-label for="requirements" :value="__('Persyaratan (Opsional)')" />
                            {{-- Menggunakan data lama: old('requirements', $karir->requirements) --}}
                            <textarea id="requirements" name="requirements" rows="10" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('requirements', $karir->requirements) }}</textarea>
                            <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                        </div>
                        
                        {{-- Status Publish --}}
                        <div class="block mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                {{-- Menggunakan data lama: old('is_active', $karir->is_active) --}}
                                <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $karir->is_active) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Aktifkan Lowongan (Tampilkan di Website)') }}</span>
                            </label>
                        </div>
                        
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center justify-end mt-4 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-xl">
                        <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
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