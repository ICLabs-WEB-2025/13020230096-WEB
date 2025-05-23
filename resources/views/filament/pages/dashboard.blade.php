<x-filament::page>
    <h2 class="text-xl font-bold mb-2">Deskripsi TPA</h2>
    <p class="mb-4">{{ $deskripsi }}</p>

    <h2 class="text-lg font-semibold mt-4 mb-2">Kegiatan TPA</h2>
    <ul class="list-disc pl-5 mb-4">
        @foreach ($kegiatan as $k)
            <li>{{ $k }}</li>
        @endforeach
    </ul>

    <h2 class="text-lg font-semibold mt-4 mb-2">Materi TPA</h2>
    <ul class="list-disc pl-5 mb-4">
        @foreach ($materi as $m)
            <li>{{ $m }}</li>
        @endforeach
    </ul>

    <h2 class="text-lg font-semibold mt-4 mb-2">Jadwal TPA</h2>
    <table class="table-auto w-full mb-4">
        <thead>
            <tr>
                <th class="border px-2 py-1">Nama Kegiatan</th>
                <th class="border px-2 py-1">Hari</th>
                <th class="border px-2 py-1">Jam</th>
                <th class="border px-2 py-1">Tempat</th>
                <th class="border px-2 py-1">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $j)
            <tr>
                <td class="border px-2 py-1">{{ $j->nama_kegiatan }}</td>
                <td class="border px-2 py-1">{{ $j->hari }}</td>
                <td class="border px-2 py-1">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                <td class="border px-2 py-1">{{ $j->tempat }}</td>
                <td class="border px-2 py-1">{{ $j->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::page>
