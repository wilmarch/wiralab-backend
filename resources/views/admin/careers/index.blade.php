<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Lowongan Karir') }}
            </h2>
            <a href="{{ route('admin.careers.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white uppercase tracking-wider shadow-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="bi bi-plus-lg me-2"></i> Tambah Lowongan
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 1. PANGGIL FORM FILTER --}}
                    @include('admin.careers._filter-form', [
                        'jobCategories' => $jobCategories,
                        'companies' => $companies,
                        'locations' => $locations
                    ])

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-bold">Judul Pekerjaan</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Perusahaan</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Lokasi</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Kategori</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Batas Lamar</th>
                                    <th scope="col" class="px-6 py-3 font-bold">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($careers as $career)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $career->title }}</th>
                                    <td class="px-6 py-4">{{ $career->company->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $career->location->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $career->jobCategory->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $career->closing_date ? $career->closing_date->format('d M Y') : 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        @if ($career->is_active)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex justify-end space-x-2">
                                        <a href="{{ route('admin.careers.show', ['karir' => $career]) }}" title="Detail" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 shadow-sm">
                                            <i class="bi bi-eye-fill me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.careers.edit', ['karir' => $career]) }}" title="Edit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.careers.destroy', ['karir' => $career]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus lowongan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                                <i class="bi bi-trash3 me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 italic">Tidak ada data lowongan karir yang cocok dengan filter.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        {!! $careers->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>