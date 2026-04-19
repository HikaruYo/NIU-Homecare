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
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa booking selesai dan pendapatan untuk tahun
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
            <p class="text-gray-400 text-xs">Booking Selesai Bulan Ini</p>
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
                <p class="text-gray-400 text-xs">Total Pendapatan Booking Selesai Tahun {{ $year }}</p>
                <h2 class="text-3xl font-bold text-mainColor mt-1">Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </h2>
            </div>
            <p class="text-sm text-gray-500">Akumulasi booking dengan status <span
                    class="font-semibold text-mainColor">selesai</span>.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                <div class="flex justify-between text-sm font-semibold text-gray-700 mb-2">
                    <h3>Grafik Pendapatan Booking Selesai {{ $year }}</h3>
                    <button type="button" class="text-mainColor hover:underline open-report-modal cursor-pointer"
                        data-report-mode="revenue">Detail</button>
                </div>
                <div class="h-64">
                    <canvas id="pendapatanLineChart"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3">
                <div class="flex justify-between text-sm font-semibold text-gray-700 mb-2">
                    <h3>Grafik Jumlah Booking Selesai {{ $year }}</h3>
                    <button type="button" class="text-mainColor hover:underline open-report-modal cursor-pointer"
                        data-report-mode="booking">Detail</button>
                </div>
                <div class="h-64">
                    <canvas id="bookingLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div id="reportListModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div id="reportListModalContent"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full opacity-0 scale-95 duration-300">
                <div class="bg-white px-6 py-6">
                    <div class="flex items-start justify-between gap-3 mb-5 border-b border-gray-100 pb-4">
                        <div>
                            <h2 id="report-list-title" class="text-2xl font-bold text-gray-800">Detail Data</h2>
                            <p id="report-list-subtitle" class="text-sm text-gray-500 mt-1"></p>
                        </div>
                        <button type="button"
                            class="close-report-list-modal px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition cursor-pointer">
                            Tutup
                        </button>
                    </div>

                    <div id="report-list-body" class="space-y-5 max-h-[70vh] overflow-y-auto pr-1"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="reportBookingModal" class="fixed inset-0 z-60 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div id="reportBookingModalContent"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 scale-95 duration-300">
                <div class="bg-white px-8 py-7">
                    <div class="flex items-start justify-between gap-3 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
                        <span id="report-modal-status"
                            class="px-3 py-1 rounded-full text-xs font-bold uppercase"></span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Nama Pelanggan</p>
                                <p id="report-modal-nama" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">No. WhatsApp</p>
                                <p id="report-modal-hp" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Alamat Kedatangan</p>
                            <p id="report-modal-alamat" class="text-sm font-semibold text-gray-800"></p>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Layanan Yang Dipilih</p>
                            <div id="report-modal-layanans-list" class="space-y-2 bg-gray-50 p-3 rounded-xl"></div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Waktu Jadwal</p>
                            <p id="report-modal-jadwal" class="text-sm font-bold text-mainColor"></p>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Total Tarif</p>
                            <p id="report-modal-total" class="text-base font-bold text-gray-900"></p>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button"
                            class="close-report-booking-modal flex-1 px-4 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition cursor-pointer">
                            Tutup
                        </button>
                    </div>
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

            const reportGroups = @json($reportGroups);
            const reportListModal = document.getElementById('reportListModal');
            const reportListContent = document.getElementById('reportListModalContent');
            const reportListTitle = document.getElementById('report-list-title');
            const reportListSubtitle = document.getElementById('report-list-subtitle');
            const reportListBody = document.getElementById('report-list-body');

            const reportBookingModal = document.getElementById('reportBookingModal');
            const reportBookingContent = document.getElementById('reportBookingModalContent');

            const reportModalStatus = document.getElementById('report-modal-status');
            const reportModalNama = document.getElementById('report-modal-nama');
            const reportModalHp = document.getElementById('report-modal-hp');
            const reportModalAlamat = document.getElementById('report-modal-alamat');
            const reportModalJadwal = document.getElementById('report-modal-jadwal');
            const reportModalTotal = document.getElementById('report-modal-total');
            const reportModalLayanansList = document.getElementById('report-modal-layanans-list');

            const statusClassMap = {
                menunggu: 'bg-yellow-200 text-yellow-800',
                diterima: 'bg-green-200 text-green-800',
                ditolak: 'bg-red-200 text-red-800',
                dibatalkan: 'bg-gray-200 text-gray-800',
                selesai: 'bg-blue-200 text-blue-800',
            };

            const openModal = (modalEl, contentEl) => {
                modalEl.classList.remove('hidden');
                setTimeout(() => {
                    contentEl.classList.remove('opacity-0', 'scale-95');
                    contentEl.classList.add('opacity-100', 'scale-100');
                }, 10);
            };

            const closeModal = (modalEl, contentEl) => {
                contentEl.classList.remove('opacity-100', 'scale-100');
                contentEl.classList.add('opacity-0', 'scale-95');
                setTimeout(() => modalEl.classList.add('hidden'), 300);
            };

            const renderBookingDetail = (booking) => {
                reportModalStatus.textContent = booking.status_label || booking.status;
                reportModalStatus.className =
                    `px-3 py-1 rounded-full text-xs font-bold uppercase ${statusClassMap[booking.status] || 'bg-gray-200 text-gray-800'}`;
                reportModalNama.textContent = booking.nama || '-';
                reportModalHp.textContent = booking.no_hp || '-';
                reportModalAlamat.textContent = booking.alamat || '-';
                reportModalJadwal.textContent = `${booking.tanggal_indo} • Jam ${booking.jam_mulai || '-'}`;
                reportModalTotal.textContent = booking.total_display || '-';

                reportModalLayanansList.innerHTML = (booking.layanans || []).map((layanan) => `
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">${layanan.nama} (${layanan.durasi}m)</span>
                        <span class="font-bold text-gray-900">Rp ${layanan.harga}</span>
                    </div>
                `).join('');

                openModal(reportBookingModal, reportBookingContent);
            };

            const renderReportList = (mode) => {
                const isRevenue = mode === 'revenue';
                reportListTitle.textContent = isRevenue ? 'Detail Grafik Pendapatan' : 'Detail Grafik Booking';
                reportListSubtitle.textContent = isRevenue ?
                    'Daftar booking selesai, dikelompokkan per bulan dan diurutkan dari tanggal paling awal.' :
                    'Daftar booking selesai, dikelompokkan per bulan dan diurutkan dari tanggal paling awal.';

                if (!reportGroups.length) {
                    reportListBody.innerHTML =
                        '<p class="text-center text-gray-500 py-10">Tidak ada data booking selesai pada tahun ini.</p>';
                    return;
                }

                reportListBody.innerHTML = reportGroups.map((group) => {
                    const itemsHtml = group.items.map((booking) => `
                        <button type="button"
                            class="w-full text-left rounded-xl border border-gray-100 bg-white p-3 hover:border-mainColor hover:shadow-sm transition report-booking-item cursor-pointer"
                            data-booking='${JSON.stringify(booking).replace(/'/g, '&#39;')}'
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-800">${booking.nama}</p>
                                    <p class="text-xs text-gray-500 mt-1">${booking.tanggal_short}</p>
                                </div>
                                ${isRevenue ? `<p class="text-sm font-bold text-mainColor">${booking.total_display}</p>` : ''}
                            </div>
                        </button>
                    `).join('');

                    return `
                        <section class="space-y-3">
                            <div class="flex items-center gap-3 sticky top-0 bg-white/95 backdrop-blur-sm py-1">
                                <h4 class="text-lg font-bold text-gray-800">${group.label}</h4>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">${group.items.length} pemesan</span>
                            </div>
                            <div class="space-y-2">
                                ${itemsHtml}
                            </div>
                        </section>
                    `;
                }).join('');

                document.querySelectorAll('.report-booking-item').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const booking = JSON.parse(btn.dataset.booking);
                        renderBookingDetail(booking);
                    });
                });

                openModal(reportListModal, reportListContent);
            };

            document.querySelectorAll('.open-report-modal').forEach((btn) => {
                btn.addEventListener('click', () => renderReportList(btn.dataset.reportMode || 'revenue'));
            });

            document.querySelectorAll('.close-report-list-modal').forEach((btn) => {
                btn.addEventListener('click', () => closeModal(reportListModal, reportListContent));
            });

            document.querySelectorAll('.close-report-booking-modal').forEach((btn) => {
                btn.addEventListener('click', () => closeModal(reportBookingModal, reportBookingContent));
            });

            reportListModal.addEventListener('click', (e) => {
                if (e.target === reportListModal) closeModal(reportListModal, reportListContent);
            });

            reportBookingModal.addEventListener('click', (e) => {
                if (e.target === reportBookingModal) closeModal(reportBookingModal, reportBookingContent);
            });
        });
    </script>

</div>
