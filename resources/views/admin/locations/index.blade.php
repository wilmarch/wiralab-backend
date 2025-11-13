<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Lokasi Karir') }}
            </h2>
            <a href="{{ route('admin.locations.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white uppercase tracking-wider shadow-md hover:bg-indigo-700">
                <i class="bi bi-plus-lg me-2"></i> Tambah Lokasi
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

                    {{-- Tabel Daftar Lokasi --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold">Nama Lokasi</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Slug (URL)</th>
                                    <th scope="col" class="px-6 py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($locations as $location)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <th scope="row" class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $location->name }}
                                        </th>
                                        <td class="px-6 py-4 font-mono text-xs">
                                            {{ $location->slug }}
                                        </td>
                                        <td class="px-6 py-4 flex justify-end space-x-2">
                                            <a href="{{ route('admin.locations.edit', ['lokasi' => $location]) }}"
                                               title="Edit"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.locations.destroy', ['lokasi' => $location]) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Yakin hapus lokasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                                            Belum ada data lokasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8 flex justify-end">
                        {{ $locations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
