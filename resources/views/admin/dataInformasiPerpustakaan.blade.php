<!-- resources/views/dashboard.blade.php -->
<x-app-admin-layout class="h-screen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 h-full">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div id="content" class="flex h-full min-h-full max-h-full">
        @include('layouts.sidebarAdmin')
        <div class="px-[40px] w-[84%]">
                {{-- @if (session('success'))
                <div class="bg-green-400 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif --}}

                <div class="flex justify-between items-center mt-6">
                    <p class="text-xl font-semibold">Data Informasi Perpustakaan</p>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <form action="{{ route('informasi.index') }}" method="GET" class="flex items-center ">
                        <input type="text" id="search" name="search" placeholder="Cari Data Informasi"
                            class="p-2 border border-blue-600 rounded-l-[50px] focus:outline-none focus:ring-2 focus:ring-blue-600 placeholder:text-[14px] placeholder:text-slate-400">
                        <button type="submit" class="p-2 w-full h-full bg-blue-600 text-slate-50 font-medium rounded-r-md hover:bg-blue-500 transition text-[14px]">
                            <svg class="" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48"><g fill="none" stroke="white" stroke-linejoin="round" stroke-width="4"><path d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4S4 11.611 4 21s7.611 17 17 17Z"/><path stroke-linecap="round" d="M26.657 14.343A7.98 7.98 0 0 0 21 12a7.98 7.98 0 0 0-5.657 2.343m17.879 18.879l8.485 8.485"/></g></svg>
                        </button>
                    </form>
                    <div class="bg-blue-600 hover:bg-blue-700 px-2 py-2 h-[40px] flex justify-center items-center rounded-md">
                        <a href="{{ route('informasi.create') }}" class="text-slate-50">Tambah Informasi</a>
                    </div>
                </div>

                @if ($informasi->isEmpty())
                <div class="text-center h-[100px] my-[100px]">
                    <h1 class="text-lg font-medium text-gray-600">Tidak ada informasi</h1>
                </div>
                @else
                <div class="relative overflow-x-auto overflow-y-auto max-h-[320px] shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs bg-blue-600 w-full text-gray-700 uppercase  dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-slate-50 w-full">
                                <th scope="col" class="px-4 py-2 w-[10px] border-l border-r border-blue-500">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 border-l border-r border-blue-500">
                                    Judul
                                </th>
                                <th scope="col" class="px-6 py-3 border-l border-r border-blue-500">
                                    Isi
                                </th>

                                <th scope="col" class="px-6 py-3 border-l border-r border-blue-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="w-[2000px] overflow-y-auto">
                            @foreach ($informasi as $info)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-slate-200 even:dark:bg-gray-800 border-b-slate-200 dark:border-gray-700">
                                <td class="px-4 py-2 w-[10px]">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 border-l border-r border-slate-200">
                                    {{ $info->title }}
                                </td>
                                <td class="px-6 py-4 border-l border-r border-slate-200">
                                    {{ $info->content }}
                                </td>

                                <td class="px-6 py-4 ">
                                    {{-- <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/>
                                        </svg>
                                    </a> --}}
                                    <a href="{{ route('informasi.edit', $info->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('informasi.destroy', $info->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Anda Yakin Ingin Menghapusnya?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit"
                                              class="text-red-500 hover:underline">
                                          Hapus
                                      </button>
                                    </form>
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
        </div>

    </div>
</x-app-admin-layout>


