import './bootstrap';
import flatpickr from "flatpickr";

import {
    Ripple,
    initTWE,
} from "tw-elements";

initTWE({ Ripple });

// Tombol panah untuk auto scroll ke atas
const upButton = document.getElementById("btn-back-to-top");
if (upButton) {
    const scrollFunction = () => {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            upButton.classList.remove("hidden");
        } else {
            upButton.classList.add("hidden");
        }
    };
    const backToTop = () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

    upButton.addEventListener("click", backToTop);
    window.addEventListener("scroll", scrollFunction);
}


// Animasi untuk logo kalender
const calendarSvg = document.getElementById("animated-calendar");
if (calendarSvg) {
    const runAnimation = () => {
        calendarSvg.classList.remove('animate-calendar');

        setTimeout(() => {
            calendarSvg.classList.add('animate-calendar');
        }, 50);
    };
    runAnimation();
    setInterval(runAnimation, 10000);
}


// Membuat password terlihat/tidak terlihat saat login/register
// app.js
document.addEventListener('DOMContentLoaded', function Eye() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    const eyeOpenConf = document.getElementById('eye-open-conf');
    const eyeClosedConf = document.getElementById('eye-closed-conf');

    if (eyeOpen && eyeClosed && passwordInput) {
        eyeOpen.addEventListener('click', function () {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        });

        eyeClosed.addEventListener('click', function () {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        });
    }

    if (eyeOpenConf && eyeClosedConf && passwordConfirmationInput) {
        eyeOpenConf.addEventListener('click', function () {
            passwordConfirmationInput.type = 'text';
            eyeOpenConf.classList.add('hidden');
            eyeClosedConf.classList.remove('hidden');
        });

        eyeClosedConf.addEventListener('click', function () {
            passwordConfirmationInput.type = 'password';
            eyeOpenConf.classList.remove('hidden');
            eyeClosedConf.classList.add('hidden');
        });
    }
});

window.addEventListener("storage", function Redirect(event) {
    if (event.key === "logout") {
        window.location.href = "/login";
    }
    if (event.key === "login") {
        if (localStorage.getItem("role") === "admin") {
            window.location.href = "/admin/dashboard";
        } else {
            window.location.href = "/dashboard";
        }
    }
});


// Date Picker
const datepickerEl = document.getElementById("datepicker");

if (datepickerEl) {
    // Jalankan logic flatpickr hanya jika elemen ada
    const fp = flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        enable: dbDates,
        minDate: new Date().fp_incr(1),
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            },
            months: {
                shorthand: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                longhand: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            },
        },
        onChange: function(selectedDates, dateStr) {
            window.location.href = "/?tanggal=" + dateStr + "#pesan";
        }
    });

    document.getElementById('openDatePicker').addEventListener('click', function () {
        fp.open();
    });

    datepickerEl.addEventListener("change", function() {
        const inputBooking = document.querySelector('input[name="tanggal_booking"]');
        if(inputBooking) {
            inputBooking.value = this.value;
        }
    });
}



// Pop-up setelah register/login
setTimeout(() => {
    const pSuccess = document.getElementById('popup');
    const pError = document.getElementById('popup-error');

    const hidePopup = (element) => {
        if (element) {
            element.style.opacity = '0';

            setTimeout(() => {
                element.style.display = 'none';
            }, 500);
        }
    };
    hidePopup(pSuccess);
    hidePopup(pError);
}, 5000);


// Logic Dropdown Profile
document.addEventListener('DOMContentLoaded', function DropdownProfile() {
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdownMenu = document.getElementById('profileDropdownMenu');
    const dropdownArrow = document.getElementById('dropdownArrow');

    // Memastikan elemen ada di halaman dan hanya muncul saat user login
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
            dropdownArrow.classList.toggle('rotate-180');
        });

        // Sembunyikan dropdown saat klik di luar area dropdown
        window.addEventListener('click', function (event) {
            if (!dropdownMenu.classList.contains('hidden')) {
                if (!dropdownMenu.contains(event.target) && event.target !== dropdownBtn) {
                    dropdownMenu.classList.add('hidden');
                    dropdownArrow.classList.remove('rotate-180');
                }
            }
        });
    }
});

// Dropdown Filter
document.addEventListener('DOMContentLoaded', function DropdownFilter() {
    const filterBtn = document.getElementById('filterDropdownBtn');
    const filterMenu = document.getElementById('filterDropdownMenu');
    const filterArrow = document.getElementById('filterDropdownArrow');

    if (filterBtn && filterMenu) {
        filterBtn.addEventListener('click', function (event) {
            event.stopPropagation();
            filterMenu.classList.toggle('hidden');
            filterArrow.classList.toggle('rotate-180');
        });

        // Sembunyikan dropdown saat klik di luar area dropdown
        window.addEventListener('click', function (event) {
            if (!filterMenu.classList.contains('hidden')) {
                if (!filterMenu.contains(event.target) && event.target !== filterBtn) {
                    filterMenu.classList.add('hidden');
                    filterArrow.classList.remove('rotate-180');
                }
            }
        });
    }
});

// Dropdown Sort
document.addEventListener('DOMContentLoaded', function DropdownSort() {
    const sortBtn = document.getElementById('sortDropdownBtn');
    const sortMenu = document.getElementById('sortDropdownMenu');
    const sortArrow = document.getElementById('sortDropdownArrow');

    if (sortBtn && sortMenu) {
        sortBtn.addEventListener('click', function (event) {
            event.stopPropagation();
            sortMenu.classList.toggle('hidden');
            sortArrow.classList.toggle('rotate-180');
        });

        // Sembunyikan dropdown saat klik di luar area dropdown
        window.addEventListener('click', function (event) {
            if (!sortMenu.classList.contains('hidden')) {
                if (!sortMenu.contains(event.target) && event.target !== sortBtn) {
                    sortMenu.classList.add('hidden');
                    sortArrow.classList.remove('rotate-180');
                }
            }
        });
    }
});


// Memunculkan/menghilangkan status alert
document.addEventListener('DOMContentLoaded', function StatusAlert() {
    const alert = document.getElementById('status-alert');

    if (alert) {
        setTimeout(() => {
            alert.classList.add('opacity-0');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 1000);
        }, 5000);
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('carousel-container');
    const nextBtn = document.querySelector('[data-carousel-next]');
    const prevBtn = document.querySelector('[data-carousel-prev]');

    if (container && nextBtn && prevBtn) {
        // Jarak scroll (pixel)
        const scrollAmount = 300;

        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
    }
});


// Search Layanan untuk Admin
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('layanan-table-body');

    if (searchInput && tableBody) {
        let timeout = null;

        searchInput.addEventListener('keyup', function () {
            clearTimeout(timeout);
            let query = this.value;

            // Debounce: tunggu 300ms setelah user berhenti mengetik
            timeout = setTimeout(() => {
                fetch(`/admin/dashboard/layanan/search?q=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        tableBody.innerHTML = ''; // Kosongkan tabel saat ini

                        if (data.length === 0) {
                            tableBody.innerHTML = `<tr><td colspan="5" class="p-3 text-center">Data tidak ditemukan</td></tr>`;
                            return;
                        }

                        data.forEach(item => {
                            const id = item.layanan_id;
                            const nominal = new Intl.NumberFormat('id-ID').format(item.nominal);

                            tableBody.innerHTML += `
                                <tr class="border-b border-gray-300 text-gray-600">
                                    <td class="p-3">${item.nama_layanan}</td>
                                    <td class="p-3">Rp ${nominal}</td>
                                    <td class="p-3">${item.deskripsi || '-'}</td>
                                    <td class="p-3">${item.durasi} menit</td>
                                    <td class="p-3 flex gap-2">
                                        <a href="/admin/dashboard/layanan/${id}/edit" class="px-3 py-1 bg-mainGray text-white rounded">Edit</a>
                                        <form method="POST" action="/admin/dashboard/layanan/${id}">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>`;
                        });
                    })
                    .catch(error => console.error('Error saat search:', error));
            }, 200);
        });
    }
});


// Logic untuk booking
document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.getElementById("layanan-wrapper");
    const template = document.getElementById("layanan-template");
    const btnAdd = document.getElementById("add-layanan");
    const totalField = document.getElementById("total-harga");
    const slotsContainer = document.getElementById("selected-slots-container");
    const slotItems = document.querySelectorAll(".slot-item");
    const inputStartTime = document.getElementById('start_time');
    const inputEndTime = document.getElementById('end_time');

    const rupiah = (n) => "Rp " + n.toLocaleString('id-ID');
    const BUFFER_MINUTES = 30;

    function updateTotal() {
        let total = 0;
        // Hanya hitung baris yang terlihat (bukan template)
        wrapper.querySelectorAll(".layanan-row:not(template .layanan-row)").forEach(row => {
            const hargaField = row.querySelector(".harga-field");
            if(hargaField) {
                total += parseInt(hargaField.dataset.value || 0);
            }
        });
        totalField.textContent = rupiah(total);
    }

    // Menghitung total durasi (durasi tetap ataupun fleksibel)
    function getTotalDuration() {
        let totalMenit = 0;
        // Loop semua baris layanan yang aktif
        wrapper.querySelectorAll(".layanan-row").forEach(row => {
            const select = row.querySelector(".layanan-select");
            const durasiInput = row.querySelector(".durasi-input"); // Ambil dari hidden input

            // Hanya hitung jika layanan sudah dipilih
            if (select && select.value && durasiInput) {
                totalMenit += parseInt(durasiInput.value || 0);
            }
        });
        return totalMenit;
    }

    // Menerapkan pilihan slot berdasarkan waktu mulai yang sudah ada
    function applySlotSelection(startTime) {
        if (!startTime) return;

        const totalDurasi = getTotalDuration();
        if (totalDurasi <= 0) return;

        const [h, m] = startTime.split(":").map(Number);
        const startDate = new Date(2000, 1, 1, h, m);
        const serviceEndDate = new Date(startDate.getTime() + totalDurasi * 60000);
        const bookingEndDate = new Date(startDate.getTime() + (totalDurasi + BUFFER_MINUTES) * 60000);

        const endServiceStr = serviceEndDate.toTimeString().slice(0,5);
        const endBookingStr = bookingEndDate.toTimeString().slice(0,5);

        // Validasi ketersediaan jika durasi bertambah
        if (!cekSlotAvailable(startTime, endBookingStr)) {
            alert(`Slot waktu tidak cukup untuk total durasi baru (memerlukan jeda ${BUFFER_MINUTES} mnt). Slot direset.`);
            resetSlotSelection();
            return;
        }

        // Update UI
        if(inputEndTime) inputEndTime.value = endServiceStr;
        document.getElementById("displayStart").textContent = startTime;
        document.getElementById("displayEnd").textContent = endServiceStr;

        // Update Hidden Inputs untuk Database
        if (slotsContainer) {
            slotsContainer.innerHTML = "";
            let loopDate = new Date(startDate);
            while (loopDate < bookingEndDate) {
                const timeStr = loopDate.toTimeString().slice(0, 5);
                const slotEl = document.querySelector(`.slot-item[data-time='${timeStr}']`);
                if (slotEl) {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "slot_jadwal_id[]";
                    input.value = slotEl.dataset.id;
                    slotsContainer.appendChild(input);
                }
                loopDate = new Date(loopDate.getTime() + 30 * 60000);
            }
        }
    }

    // Logic untuk memilih layanan (dropdown)
    function attachEventToRow(row) {
        const select = row.querySelector(".layanan-select");
        const durasiSelect = row.querySelector(".durasi-select");
        const durasiText = row.querySelector(".durasi-text");
        const durasiInput = row.querySelector(".durasi-input");
        const hargaField = row.querySelector(".harga-field");
        const removeBtn = row.querySelector(".remove-row");

        // Hapus baris
        if (removeBtn) {
            removeBtn.addEventListener("click", () => {
                row.remove();
                updateTotal();
                // Otomatis update saat baris dihapus
                if (inputStartTime && inputStartTime.value) applySlotSelection(inputStartTime.value);
            });
        }

        // Logic untuk mengganti layanan yang ingin dipesan
        select.addEventListener("change", () => {
            const opt = select.selectedOptions[0];
            if (!opt || !opt.value) {
                durasiInput.value = 0;
                updateTotal();
                return;
            }

            const isFlex = opt.dataset.flex === "1";
            const baseDurasi = parseInt(opt.dataset.durasi);
            const baseHarga = parseInt(opt.dataset.harga);
            const harga30 = parseInt(opt.dataset.harga30);

            if (!isFlex) {
                // Layanan dengan durasi tetap
                durasiSelect.classList.add("hidden");
                durasiText.classList.remove("hidden");
                durasiText.textContent = baseDurasi + " menit";
                durasiInput.value = baseDurasi; // Set hidden input
                hargaField.textContent = rupiah(baseHarga);
                hargaField.dataset.value = baseHarga;
            } else {
                // Layanan dengan durasi fleksibel
                durasiText.classList.add("hidden");
                durasiSelect.classList.remove("hidden");

                // Reset opsi durasi
                durasiSelect.innerHTML = "";
                for (let m = 30; m <= 60; m += 30) { // Membatasi maksimal layanan fleksibel hingga 3 jam
                    const op = document.createElement("option");
                    op.value = m;
                    op.textContent = m + " menit";
                    durasiSelect.appendChild(op);
                }

                // Logic saat durasi fleksibel berubah
                durasiSelect.onchange = () => {
                    durasiInput.value = durasiSelect.value;
                    const hargaAkhir = (durasiSelect.value / 30) * harga30;
                    hargaField.textContent = rupiah(hargaAkhir);
                    hargaField.dataset.value = hargaAkhir;
                    updateTotal();
                    // Otomatis update jam saat durasi fleksibel berubah
                    if (inputStartTime.value) applySlotSelection(inputStartTime.value);
                };

                // Default durasi fleksibel adalah 30 menit
                durasiSelect.value = durasiInput.value > 0 ? durasiInput.value : 30;
                durasiSelect.dispatchEvent(new Event("change"));
            }
            updateTotal();
            // Otomatis update jam saat layanan berubah
            if (inputStartTime.value) applySlotSelection(inputStartTime.value);
        });

        // Jika select sudah ada nilainya (autofill/old input), jalankan logicnya
        if (select.value) {
            select.dispatchEvent(new Event("change"));
        }
    }

    // Logic untuk menambah layanan yang ingin dipesan
    if (btnAdd && template) {
        btnAdd.addEventListener("click", () => {
            // Clone template content
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector(".layanan-row");
            // Pasang event listener ke baris baru
            attachEventToRow(row);
            // Masukkan ke wrapper
            wrapper.appendChild(row);
            // Otomatis update jam saat baris baru ditambah
            if (inputStartTime && inputStartTime.value) applySlotSelection(inputStartTime.value);
        });
    }

    // Init Event untuk baris pertama
    document.querySelectorAll("#layanan-wrapper > .layanan-row").forEach(row => attachEventToRow(row));

    // Logic untuk memilih slot jadwal
    function resetSlotSelection() {
        if(slotsContainer) slotsContainer.innerHTML = "";
        if(inputStartTime) inputStartTime.value = "";
        if(inputEndTime) inputEndTime.value = "";
        document.getElementById("displayStart").textContent = "--:--";
        document.getElementById("displayEnd").textContent = "--:--";
        slotItems.forEach(s => s.classList.remove("bg-mainColor", "text-white"));
    }

    slotItems.forEach(item => {
        item.addEventListener("click", () => {
            if (getTotalDuration() <= 0) {
                alert("Silahkan pilih layanan terlebih dahulu.");
                return;
            }
            if(inputStartTime) inputStartTime.value = item.dataset.time;
            slotItems.forEach(s => s.classList.remove("bg-mainColor", "text-white"));
            item.classList.add("bg-mainColor", "text-white");
            applySlotSelection(item.dataset.time);
        });
    });

    // Helper Cek Slot
    function cekSlotAvailable(start, end) {
        const [h, m] = end.split(":").map(Number);
        const endDate = new Date(2000, 1, 1, h, m);
        let loopDate = new Date(2000, 1, 1, ...start.split(":").map(Number));
        while (loopDate < endDate) {
            const timeStr = loopDate.toTimeString().slice(0, 5);
            const slot = document.querySelector(`.slot-item[data-time='${timeStr}']`);
            if (!slot || slot.classList.contains("pointer-events-none")) return false;
            loopDate = new Date(loopDate.getTime() + 30 * 60000);
        }
        return true;
    }
});


// Konfirmasi booking modal
document.addEventListener("DOMContentLoaded", () => {
    const btnPreSubmit = document.getElementById('btn-pre-submit');
    const modal = document.getElementById('confirmationModal');
    const btnCancel = document.getElementById('btn-cancel-modal');

    // Elemen untuk summary di modal
    const modalList = document.getElementById('modal-summary-list');
    const modalTotal = document.getElementById('modal-total-price');
    const modalTime = document.getElementById('modal-time-range');

    // Input hidden di main form
    const inputStartTime = document.getElementById('start_time');
    const inputEndTime = document.getElementById('end_time');

    // Fungsi Tampilkan Modal
    btnPreSubmit.addEventListener('click', () => {
        // Cek apakah ada layanan dan waktu dipilih
        const layananRows = document.querySelectorAll("#layanan-wrapper .layanan-row:not(template .layanan-row)");
        const hasService = Array.from(layananRows).some(row => {
            const select = row.querySelector('.layanan-select');
            return select && select.value;
        });

        if (!hasService) {
            alert("Silakan pilih minimal satu layanan.");
            return;
        }

        if (!inputStartTime.value || !inputEndTime.value) {
            alert("Silakan pilih jam mulai pada jadwal.");
            return;
        }

        // Isi Data Summary ke Modal
        modalList.innerHTML = ''; // Reset list
        let grandTotal = 0;

        layananRows.forEach(row => {
            const select = row.querySelector('.layanan-select');
            const hargaField = row.querySelector('.harga-field');
            const durasiInput = row.querySelector('.durasi-input');

            if (select && select.value) {
                const namaLayanan = select.options[select.selectedIndex].text.trim();
                const harga = parseInt(hargaField.dataset.value || 0);
                const durasi = durasiInput.value;

                grandTotal += harga;

                // Buat elemen HTML list item
                const item = document.createElement('div');
                item.className = "flex justify-between border-b border-dashed pb-1";
                item.innerHTML = `
                        <span class="text-gray-800">${namaLayanan} <span class="text-xs text-gray-500">(${durasi} mnt)</span></span>
                        <span class="font-medium">Rp ${harga.toLocaleString('id-ID')}</span>
                    `;
                modalList.appendChild(item);
            }
        });

        modalTotal.textContent = "Rp " + grandTotal.toLocaleString('id-ID');
        modalTime.textContent = `${inputStartTime.value} s/d ${inputEndTime.value}`;

        // Tampilkan Modal
        modal.classList.remove('hidden');
    });

    // Fungsi Tutup Modal
    btnCancel.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Tutup modal jika klik di luar area modal
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

// Modal edit profil
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editProfileModal');
    const modalContent = document.getElementById('modalContent');
    const openBtn = document.getElementById('openEditModal');
    const closeBtn = document.getElementById('closeEditModal');
    const cancelBtn = document.getElementById('btnCancel');

    function toggleModal() {
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    openBtn.addEventListener('click', toggleModal);
    closeBtn.addEventListener('click', toggleModal);
    cancelBtn.addEventListener('click', toggleModal);

    // Tutup modal jika klik di luar area modal content
    modal.addEventListener('click', (e) => {
        if (e.target === modal) toggleModal();
    });
});
