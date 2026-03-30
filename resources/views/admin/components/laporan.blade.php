<div class="flex flex-col w-full h-full gap-4 bg-mainGray shadow-lg rounded-lg">
    {{-- Notification --}}
    @if (session('status'))
        <div id="status-alert"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg right-2 absolute mb-4 transition-opacity duration-1000 ease-out"
            role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <div class="mx-6 py-3 border-b-2 border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-4xl font-semibold text-gray-800">Laporan Penghasilan</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa booking dan pendapatan untuk tahun
                {{ $year }}.</p>
        </div>

        <form method="GET" action="{{ route('admin.dashboard.laporan') }}" class="flex items-center gap-2">
            <label for="year" class="text-sm text-gray-500">Tahun:</label>
            <select id="year" name="year" onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-mainColor">
                @foreach ($availableYears as $availableYear)
                    <option value="{{ $availableYear }}" {{ (int) $year === (int) $availableYear ? 'selected' : '' }}>
                        {{ $availableYear }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 mx-6 gap-3">
        <!-- Total Booking Bulan Ini -->
        <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs">Booking Bulan Ini</p>
            <h2 class="text-2xl font-bold text-mainColor leading-tight mt-1">
                {{ $totalBookingBulanIni }}
            </h2>
        </div>

        <!-- Diterima -->
        <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs">Diterima</p>
            <h2 class="text-2xl font-bold text-green-600 leading-tight mt-1">
                {{ $bookingDiterima }}
            </h2>
        </div>

        <!-- Menunggu -->
        <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs">Menunggu</p>
            <h2 class="text-2xl font-bold text-yellow-500 leading-tight mt-1">
                {{ $bookingMenunggu }}
            </h2>
        </div>

        <!-- Ditolak -->
        <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs">Ditolak</p>
            <h2 class="text-2xl font-bold text-red-500 leading-tight mt-1">
                {{ $bookingDitolak }}
            </h2>
        </div>

        <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100 col-span-2 lg:col-span-1">
            <p class="text-gray-400 text-xs">Dibatalkan</p>
            <h2 class="text-2xl font-bold text-gray-600 leading-tight mt-1">
                {{ $bookingDibatalkan }}
            </h2>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="mx-6 bg-white rounded-2xl shadow border border-gray-100 p-2 md:p-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 border-b border-gray-100 pb-4 mb-4">
            <div>
                <p class="text-gray-400 text-xs">Total Pendapatan Tahun {{ $year }}</p>
                <h2 class="text-3xl font-bold text-mainColor mt-1">Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </h2>
            </div>
            <p class="text-sm text-gray-500">Akumulasi booking dengan status <span
                    class="font-semibold text-mainColor">diterima</span>.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Grafik Pendapatan Bulanan {{ $year }}</h3>
                <div class="h-64">
                    <canvas id="pendapatanLineChart"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Grafik Jumlah Booking Bulanan {{ $year }}
                </h3>
                <div class="h-64">
                    <canvas id="bookingLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('pendapatanLineChart');
            if (!ctx) return;

            const labels = @json($chartLabels);
            const values = @json($chartData);
            const legendLabel = @json($chartLegend);
            const bookingLabels = @json($bookingChartLabels);
            const bookingValues = @json($bookingChartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: legendLabel,
                        data: values,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.14)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: '#16a34a',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#374151'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            const bookingCtx = document.getElementById('bookingLineChart');
            if (!bookingCtx) return;

            new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: bookingLabels,
                    datasets: [{
                        label: 'Total Booking Bulanan',
                        data: bookingValues,
                        borderColor: '#6b7280',
                        backgroundColor: 'rgba(107, 114, 128, 0.14)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: '#6b7280',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#374151'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>

</div>
