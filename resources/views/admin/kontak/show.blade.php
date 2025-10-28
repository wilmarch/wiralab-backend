<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pesan Masuk') }}
            </h2>
            
            {{-- TOMBOL KEMBALI DI HEADER --}}
            <a href="{{ route('admin.kontak.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- KARTU UTAMA --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                
                <div class="p-5 md:p-6">
                    
                    {{-- Judul (Subjek) Postingan --}}
                    <div class="border-b pb-3 mb-4 dark:border-gray-700">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">SUBJEK</dt>
                        <dd class="mt-0.5 text-2xl font-extrabold text-gray-900 dark:text-white">
                            {{ $kontak->subject ?? '(Tanpa Subjek)' }}
                        </dd>
                    </div>

                    {{-- DETAIL INFORMASI PENGIRIM (List Rapat) --}}
                    <dl class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- Pengirim --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PENGIRIM</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0 font-medium">
                                {{ $kontak->name }}
                            </dd>
                        </div>
                        
                        {{-- Diterima --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DITERIMA PADA</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{ $kontak->created_at->format('d M Y H:i:s') }}
                            </dd>
                        </div>
                        
                        {{-- Email (LINK) --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">EMAIL</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 font-medium">
                                <a href="mailto:{{ $kontak->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    <i class="bi bi-envelope-fill me-1 text-blue-500"></i> {{ $kontak->email }}
                                </a>
                            </dd>
                        </div>

                        {{-- Telepon (LINK TEL & WA) --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TELEPON</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 space-x-4">
                                @php
                                    // PERBAIKAN: Gunakan namespace penuh untuk helper Str agar tidak error
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $kontak->phone);
                                    $waNumber = \Illuminate\Support\Str::startsWith($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                                @endphp
                                
                                {{-- Link Telepon --}}
                                <a href="tel:{{ $kontak->phone }}" class="text-gray-900 dark:text-gray-100 hover:underline font-medium">
                                    <i class="bi bi-telephone-fill me-1 text-blue-500"></i> {{ $kontak->phone ?? '-' }}
                                </a>
                                
                                {{-- Link WhatsApp --}}
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="text-green-600 dark:text-green-400 hover:underline font-medium">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </dd>
                        </div>
                        
                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}

                    {{-- ISI PESAN LENGKAP --}}
                    <section class="mt-8 pt-6 border-t dark:border-gray-700">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Isi Pesan</h4>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-inner border border-gray-200 dark:border-gray-600">
                            <p class="whitespace-pre-wrap">{{ $kontak->body }}</p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>