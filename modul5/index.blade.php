<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Buku</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-700 text-left text-sm uppercase font-semibold">
                        <th class="py-3 px-4 border-r">ID</th>
                        <th class="py-3 px-4 border-r">Judul Buku</th>
                        <th class="py-3 px-4 border-r">Penulis</th>
                        <th class="py-3 px-4 border-r">Status</th>
                        <th class="py-3 px-4 border-r">Peminjam</th>
                        <th class="py-3 px-4 text-center">File</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($books as $book)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 border-r">{{ $book['id'] }}</td>
                            <td class="py-3 px-4 border-r font-medium text-gray-900">{{ $book['title'] }}</td>
                            <td class="py-3 px-4 border-r">{{ $book['author'] }}</td>

                            <!-- Status Ketersediaan -->
                            <td class="py-3 px-4 border-r">
                                @if($book['is_available'])
                                    <span
                                        class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Tersedia</span>
                                @else
                                    <span
                                        class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Dipinjam</span>
                                @endif
                            </td>

                            <!-- Data Member (jika ada) -->
                            <td class="py-3 px-4 border-r">
                                {{ $book['member']['name'] ?? '-' }}
                            </td>

                            <!-- Langsung pakai file_url dari BookResource -->
                            <td class="py-3 px-4 text-center">
                                @if(!empty($book['file_url']))
                                    <a href="{{ $book['file_url'] }}" target="_blank"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium">
                                        Buka File
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">
                                Tidak ada data buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if(isset($meta) && $meta['last_page'] > 1)
            <div class="flex justify-between items-center mt-6">
                <div>
                    @if($links['prev'])
                        <a href="?page={{ $meta['current_page'] - 1 }}"
                            class="px-4 py-2 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">
                            &laquo; Prev
                        </a>
                    @endif
                </div>

                <span class="text-sm text-gray-600">
                    Halaman <strong>{{ $meta['current_page'] }}</strong> dari <strong>{{ $meta['last_page'] }}</strong>
                    (Total: {{ $meta['total'] }} buku)
                </span>

                <div>
                    @if($links['next'])
                        <a href="?page={{ $meta['current_page'] + 1 }}"
                            class="px-4 py-2 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">
                            Next &raquo;
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</body>

</html>