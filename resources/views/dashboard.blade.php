<x-app-layout> {{-- This uses the main layout: resources/views/layouts/app.blade.php --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }} {{-- Change the header title --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Selamat Datang di Admin Panel Wiralab!") }} {{-- Change the welcome message --}}

                    {{-- Add Admin-specific content here later --}}
                    <div class="mt-4 border-t pt-4">
                        <h3 class="font-semibold mb-2">Akses Cepat (Contoh):</h3>
                         {{-- You can use Tailwind classes for buttons/links --}}
                        <a href="#" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2 mb-2">
                            Kelola Produk
                        </a>
                        <a href="#" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2 mb-2">
                            Kelola Blog
                        </a>
                        <a href="#" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mb-2">
                            Kelola Karir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>