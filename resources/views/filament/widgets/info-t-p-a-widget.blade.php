<x-filament::widget>
    <div class="w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] bg-white dark:bg-gray-900 shadow-lg border border-gray-200 dark:border-gray-700 p-6 md:p-10 lg:p-12">
        <div class="max-w-7xl mx-auto">
            {{-- Deskripsi --}}
            <div class="mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-pink-600 dark:text-pink-400 mb-2 flex items-center gap-2">
                    <span>📌</span> Deskripsi TPA
                </h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $deskripsi }}</p>
            </div>

            {{-- Grid: Kegiatan dan Materi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 items-start">
                <div>
                    <h3 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-3 flex items-center gap-2">
                        <span>📝</span> Kegiatan TPA
                    </h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                        @foreach ($kegiatan as $k)
                            <li>{{ $k }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-600 dark:text-green-400 mb-3 flex items-center gap-2">
                        <span>📚</span> Materi TPA
                    </h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                        @foreach ($materi as $m)
                            <li>{{ $m }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Tabel Jadwal di bawah grid, 1 baris penuh --}}
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-orange-600 dark:text-orange-400 mb-4 flex items-center gap-2">
                    <span>🗓️</span> Jadwal TPA
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr class="text-left text-gray-700 dark:text-gray-200 uppercase text-sm">
                                <th class="px-4 py-2">Nama Kegiatan</th>
                                <th class="px-4 py-2">Hari</th>
                                <th class="px-4 py-2">Jam</th>
                                <th class="px-4 py-2">Tempat</th>
                                <th class="px-4 py-2">Keterangan</th>
                                <th class="px-4 py-2">Pengajar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                            @forelse($jadwal as $j)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="px-4 py-2">{{ $j->nama_kegiatan }}</td>
                                    <td class="px-4 py-2">{{ $j->hari }}</td>
                                    <td class="px-4 py-2">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                    <td class="px-4 py-2">{{ $j->tempat }}</td>
                                    <td class="px-4 py-2">{{ $j->keterangan }}</td>
                                    <td class="px-4 py-2">{{ $j->pengajar?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-400">Belum ada jadwal TPA.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notifikasi Jadwal Pengajar --}}
    @if (!empty($jadwalToNotify))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 10000)" 
            x-show="show" 
            x-transition
            class="fixed top-5 right-5 z-50 bg-orange-100 dark:bg-orange-900 border border-orange-300 dark:border-orange-700 text-orange-900 dark:text-orange-100 px-6 py-4 rounded-lg shadow-lg max-w-md"
        >
            <div class="flex items-center mb-2">
                <svg class="w-6 h-6 mr-2 text-orange-500 dark:text-orange-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1 4v2m-6-2a9 9 0 1118 0 9 9 0 01-18 0z" /></svg>
                <span class="font-bold">Pengingat Jadwal!</span>
            </div>
            <ul class="text-sm">
                @foreach($jadwalToNotify as $item)
                    <li class="mb-1">Anda akan mengajar <b>{{ $item['nama_kegiatan'] }}</b> pada <b>{{ $item['jam_mulai'] }}</b></li>
                @endforeach
            </ul>
            <button @click="show = false" class="absolute top-1 right-2 text-lg font-bold text-orange-500 hover:text-orange-700 dark:hover:text-orange-300">&times;</button>
        </div>
    @endif

    {{-- (Optional) Notifikasi browser popup --}}
    @if (!empty($jadwalToNotify))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (Notification && Notification.permission !== 'granted') {
                Notification.requestPermission();
            }
            if (Notification.permission === 'granted') {
                @foreach($jadwalToNotify as $item)
                    new Notification("Pengingat Jadwal!", {
                        body: "Anda akan mengajar {{ $item['nama_kegiatan'] }} pada {{ $item['jam_mulai'] }}",
                    });
                @endforeach
            }
        });
        </script>
    @endif

</x-filament::widget>
