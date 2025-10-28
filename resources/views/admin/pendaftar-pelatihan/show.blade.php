<x-app-layout>
    <x-slot name="header">
        {{-- INI ADALAH HEADER UTAMA HALAMAN --}}
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pendaftar Pelatihan') }}
            </h2>
            
            {{-- TOMBOL AKSI DIPOSISIKAN DI SINI --}}
            <a href="{{ route('admin.pendaftar-pelatihan.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8"> 
            
            {{-- KARTU UTAMA DETAIL --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl overflow-hidden">
                {{-- AREA DETAIL PENDAFTAR --}}
                <div class="p-5 md:p-6">
                    
                    {{-- Judul (Nama Pendaftar) --}}
                    <div class="border-b pb-3 mb-4 dark:border-gray-700">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">PENDAFTAR DARI INSTITUSI</dt>
                        <dd class="mt-0.5 text-2xl font-extrabold text-gray-900 dark:text-white">
                            {{ $pendaftar_pelatihan->name }}
                        </dd>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ $pendaftar_pelatihan->institution }}
                        </p>
                    </div>

                    {{-- DETAIL INFORMASI (List Rapat) --}}
                    <dl class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 overflow-hidden">
                        
                        {{-- STATUS KONTAK --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">STATUS HUBUNGAN</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                                @if ($pendaftar_pelatihan->is_contacted)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">SUDAH DIHUBUNGI</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-600 text-white shadow-sm">BARU / BELUM DITINDAK</span>
                                @endif
                            </dd>
                        </div>
                        
                        {{-- Tipe Training Dipilih --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TIPE TRAINING DIPILIH</dt>
                            <dd class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400 sm:col-span-2 sm:mt-0">
                                {{ $pendaftar_pelatihan->training->name ?? 'Tipe Dihapus' }}
                            </dd>
                        </div>

                        {{-- Email (LINK) --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">EMAIL</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 font-medium">
                                <a href="mailto:{{ $pendaftar_pelatihan->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $pendaftar_pelatihan->email }}
                                </a>
                            </dd>
                        </div>

                        {{-- Telepon (LINK TEL & WA) --}}
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TELEPON</DT>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0 space-x-4">
                                {{-- Link Telepon --}}
                                <a href="tel:{{ $pendaftar_pelatihan->phone }}" class="text-gray-900 dark:text-gray-100 hover:underline font-medium">
                                    <i class="bi bi-telephone-fill me-1 text-blue-500"></i> {{ $pendaftar_pelatihan->phone }}
                                </a>
                                
                                {{-- Link WhatsApp --}}
                                @php
                                    // Membersihkan dan mengkonversi nomor (misal: 0812 -> 62812)
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $pendaftar_pelatihan->phone);
                                    $waNumber = Str::startsWith($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="text-green-600 dark:text-green-400 hover:underline font-medium">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </dd>
                        </div>
                        
                        {{-- Diterima Pada --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">WAKTU PENDAFTARAN</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{ $pendaftar_pelatihan->created_at->format('d M Y H:i:s') }}
                            </dd>
                        </div>
                        
                    </dl>
                    {{-- AKHIR DETAIL INFORMASI --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>