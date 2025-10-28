<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Blog (Artikel & Berita)') }}
            </h2>
            {{-- Tombol Tambah Postingan --}}
            <a href="{{ route('admin.blog.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white uppercase tracking-wider shadow-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-plus-lg me-2"></i> Tulis Postingan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Kontainer Tabel Responsif --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                            
                            {{-- Header Tabel --}}
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold w-2/5">Judul</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/5">Tipe</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/5">Status</th>
                                    <th scope="col" class="px-6 py-3 font-semibold w-1/5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            
                            {{-- Body Tabel --}}
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($posts as $post)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ $post->title }}
                                    </th>
                                    <td class="px-6 py-4 uppercase">
                                        {{-- Badge Tipe --}}
                                        @if ($post->post_type === 'berita')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 shadow-sm">
                                                BERITA
                                            </span>
                                        @elseif ($post->post_type === 'artikel')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 shadow-sm">
                                                ARTIKEL
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Badge Status --}}
                                        @if ($post->is_published)
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Published
                                            </span>
                                        @else
                                             <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        <a href="{{ route('admin.blog.show', $post->slug) }}" title="Lihat Post" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 shadow-sm transition duration-150">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post->slug) }}" title="Edit Post" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition duration-150">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.blog.destroy', $post->slug) }}" method="POST" class="inline-flex items-center" onsubmit="return confirm('Yakin hapus postingan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Post" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm transition duration-150">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white dark:bg-gray-800">
                                     <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-base italic">
                                        Belum ada postingan blog. Silakan buat postingan baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-8 flex justify-end">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>