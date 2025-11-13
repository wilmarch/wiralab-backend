<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Lowongan Karir Baru') }}
        </h2>
    </x-slot>

    {{-- Asumsi Trix sudah di-load global di app.css/app.js --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                
                <form method="POST" action="{{ route('admin.careers.store') }}" novalidate>
                    @csrf 

                    <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100 space-y-6">

                        {{-- Judul Pekerjaan --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Pekerjaan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Grid 4 Kolom untuk Data Master --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            
                            {{-- 1. Kategori Pekerjaan --}}
                            <div>
                                 <x-input-label for="job_category_id" :value="__('Kategori Pekerjaan')" />
                                 <select name="job_category_id" id="job_category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                     <option value="">-- Pilih Kategori --</option>
                                     @foreach ($jobCategories as $category)
                                         <option value="{{ $category->id }}" {{ old('job_category_id') == $category->id ? 'selected' : '' }}>
                                             {{ $category->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                 <x-input-error :messages="$errors->get('job_category_id')" class="mt-2" />
                            </div>

                            {{-- 2. Perusahaan (BARU) --}}
                            <div>
                                 <x-input-label for="company_id" :value="__('Perusahaan')" />
                                 <select name="company_id" id="company_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                     <option value="">-- Pilih Perusahaan --</option>
                                     @foreach ($companies as $company)
                                         <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                             {{ $company->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                 <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>

                            {{-- 3. Lokasi (BARU) --}}
                            <div>
                                 <x-input-label for="location_id" :value="__('Lokasi')" />
                                 <select name="location_id" id="location_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                     <option value="">-- Pilih Lokasi --</option>
                                     @foreach ($locations as $location)
                                         <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                             {{ $location->name }}
                                         </option>
                                     @endforeach
                                 </select>
                                 <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                            </div>

                            {{-- 4. Batas Lamar --}}
                            <div>
                                <x-input-label for="closing_date" :value="__('Batas Tanggal Lamar')" />
                                <x-text-input id="closing_date" class="block mt-1 w-full" type="date" name="closing_date" :value="old('closing_date')" 
                                              required min="{{ $minDate }}" />
                                <x-input-error :messages="$errors->get('closing_date')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Deskripsi (Trix Editor) --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Pekerjaan')" />
                            <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                            <trix-editor input="description" class="trix-content block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm"></trix-editor>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Persyaratan (Trix Editor) --}}
                        <div>
                            <x-input-label for="requirements" :value="__('Persyaratan')" />
                            <input id="requirements" type="hidden" name="requirements" value="{{ old('requirements') }}">
                            <trix-editor input="requirements" class="trix-content block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm"></trix-editor>
                            <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
                        </div>
                        
                        <div class="block">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" name="is_active" type="checkbox" value="1" checked class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Aktifkan Lowongan (Tampilkan di Website)') }}</span>
                            </label>
                        </div>
                        
                    </div>

                    <div class="flex items-center justify-end mt-4 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-xl">
                        <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </a>
                        <x-primary-button class="ms-3">
                            {{ __('Simpan Lowongan') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>