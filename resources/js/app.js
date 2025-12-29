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
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    const eyeOpenConf = document.getElementById('eye-open-conf');
    const eyeClosedConf = document.getElementById('eye-closed-conf');

    eyeOpen.addEventListener('click', function () {
        passwordInput.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    });
    eyeOpenConf.addEventListener('click', function () {
        passwordConfirmationInput.type = 'text';
        eyeOpenConf.classList.add('hidden');
        eyeClosedConf.classList.remove('hidden');
    });
    eyeClosed.addEventListener('click', function () {
        passwordInput.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    });
    eyeClosedConf.addEventListener('click', function () {
        passwordConfirmationInput.type = 'password';
        eyeOpenConf.classList.remove('hidden');
        eyeClosedConf.classList.add('hidden');
    });
});

window.addEventListener("storage", function(event) {
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
document.addEventListener("DOMContentLoaded", function () {
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
});
// Mengambil data tanggal dari date picker agar bisa digunakan ke DB
datepicker.addEventListener("change", function() {
    document.querySelector('input[name="tanggal_booking"]').value = this.value;
});



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
document.addEventListener('DOMContentLoaded', function () {
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdownMenu = document.getElementById('profileDropdownMenu');
    const dropdownArrow = document.getElementById('dropdownArrow');

    // Memastikan elemen ada di halaman dan hanya muncul saat user login
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function (event) {
            // Mencegah event click menyebar ke window document
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

// Dropdown Filter Admin
document.addEventListener('DOMContentLoaded', function () {
    const filterBtn = document.getElementById('filterDropdownBtn');
    const filterMenu = document.getElementById('filterDropdownMenu');
    const filterArrow = document.getElementById('filterDropdownArrow');

    if (!filterBtn) return;

    filterBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        filterMenu.classList.toggle('hidden');
        filterArrow.classList.toggle('rotate-180');
    });

    window.addEventListener('click', function (e) {
        if (!filterMenu.contains(e.target) && !filterBtn.contains(e.target)) {
            filterMenu.classList.add('hidden');
            filterArrow.classList.remove('rotate-180');
        }
    });
});

// TODO: buat filter untuk halaman dashboard


// Memunculkan/menghilangkan status alert
document.addEventListener('DOMContentLoaded', function () {
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

// Logic untuk booking
document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.getElementById("layanan-wrapper");
    const template = document.getElementById("layanan-template");
    const btnAdd = document.getElementById("add-layanan");
    const totalField = document.getElementById("total-harga");
    const slotsContainer = document.getElementById("selected-slots-container");
    const slotItems = document.querySelectorAll(".slot-item");

    const rupiah = (n) => "Rp " + n.toLocaleString('id-ID');
    const BUFFER_MINUTES = 60;

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
                // Reset slot selection jika layanan berubah
                resetSlotSelection();
            });
        }

        // Logic untuk mengganti layanan yang ingin dipesan
        select.addEventListener("change", () => {
            const currentVal = select.value;
            const opt = select.selectedOptions[0];

            // Cek apakah layanan ini sudah dipilih di baris lain
            let isDuplicate = false;
            const allSelects = document.querySelectorAll(".layanan-select");
            allSelects.forEach(otherSelect => {
                // Pastikan bukan elemen yang sama dan value-nya sama
                if (otherSelect !== select && otherSelect.value === currentVal && currentVal !== "") {
                    isDuplicate = true;
                }
            });

            if (isDuplicate) {
                alert("Layanan ini sudah dipilih sebelumnya. Silakan pilih layanan lain.");
                select.value = ""; // Reset pilihan
                // Reset tampilan harga/durasi ke 0
                durasiSelect.classList.add("hidden");
                durasiText.classList.add("hidden");
                durasiInput.value = 0;
                hargaField.textContent = "Rp 0";
                hargaField.dataset.value = 0;
                updateTotal();
                resetSlotSelection();
                return;
            }

            // Jika user pilih "Pilih Layanan" (kosong) / belum memilih
            if (!opt || !opt.value) {
                durasiSelect.classList.add("hidden");
                durasiText.classList.add("hidden");
                durasiInput.value = 0;
                hargaField.textContent = "Rp 0";
                hargaField.dataset.value = 0;
                updateTotal();
                resetSlotSelection();
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
                    const durasi = parseInt(durasiSelect.value);
                    durasiInput.value = durasi; // Set hidden input

                    const hargaAkhir = (durasi / 30) * harga30;
                    hargaField.textContent = rupiah(hargaAkhir);
                    hargaField.dataset.value = hargaAkhir;
                    updateTotal();
                    resetSlotSelection(); // Reset slot karena durasi berubah
                };

                // Default durasi fleksibel adalah 30 menit
                durasiSelect.value = 30;
                durasiSelect.dispatchEvent(new Event("change"));
            }
            updateTotal();
            resetSlotSelection();
        });
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
            console.log('btn click')
        });

    }

    // Init Event untuk baris pertama
    document.querySelectorAll("#layanan-wrapper > .layanan-row").forEach(row => attachEventToRow(row));


    // Logic untuk memilih slot jadwal
    function resetSlotSelection() {
        if(slotsContainer) slotsContainer.innerHTML = "";
        document.querySelector("#start_time").value = "";
        document.querySelector("#end_time").value = "";
        document.querySelector("#displayStart").textContent = "--:--";
        if(document.querySelectorAll("#displayStart")[1]) {
            document.querySelectorAll("#displayStart")[1].textContent = "--:--";
        }
        slotItems.forEach(s => s.classList.remove("bg-mainColor", "text-white"));
    }

    slotItems.forEach(item => {
        item.addEventListener("click", () => {
            const start = item.dataset.time;
            const totalDurasi = getTotalDuration();

            // Mencegah input kosong
            if (totalDurasi <= 0) {
                alert("Silahkan pilih layanan dan durasinya terlebih dahulu.");
                return;
            }

            // Hitung waktu layanan
            const [h, m] = start.split(":").map(Number);
            const startDate = new Date(2000, 1, 1, h, m);

            // Waktu selesai layanan (Tampilan UI)
            const serviceEndDate = new Date(startDate.getTime() + totalDurasi * 60000);

            // Waktu Selesai Booking + Buffer (Logic Database)
            const bookingEndDate = new Date(startDate.getTime() + (totalDurasi + BUFFER_MINUTES) * 60000);

            // Format String HH:mm
            const endServiceStr = serviceEndDate.toTimeString().slice(0,5);
            const endBookingStr = bookingEndDate.toTimeString().slice(0,5);

            // Cek ketersediaan slot (termasuk buffer)
            if (!cekSlotAvailable(start, endBookingStr)) {
                alert(`Slot waktu tidak cukup (memerlukan jeda ${BUFFER_MINUTES} menit setelah layanan). Silakan pilih jam lain.`);
                return;
            }

            // Update Tampilan UI
            document.querySelector("#start_time").value = start;
            document.querySelector("#end_time").value = endServiceStr;
            document.querySelector("#displayStart").textContent = start;

            // Fix selector duplicate ID
            const displays = document.querySelectorAll("#displayStart");
            if(displays.length > 1) displays[1].textContent = endServiceStr;

            // Highlight Slot
            slotItems.forEach(s => s.classList.remove("bg-mainColor", "text-white"));
            item.classList.add("bg-mainColor", "text-white");

            // Memastikan input slot ada
            if (!slotsContainer) return;
            slotsContainer.innerHTML = "";

            let loopDate = new Date(startDate);
            const finalDate = bookingEndDate; // Loop sampai durasi + buffer

            // Loop untuk membuat input slot hidden
            while (loopDate < finalDate) {
                const timeStr = loopDate.toTimeString().slice(0, 5); // Format HH:mm

                // Cari elemen slot di UI yang cocok waktunya
                const slotEl = document.querySelector(`.slot-item[data-time='${timeStr}']`);

                if (slotEl) {
                    const slotId = slotEl.dataset.id;

                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "slot_jadwal_id[]";
                    input.value = slotId;

                    slotsContainer.appendChild(input);
                }
                loopDate = new Date(loopDate.getTime() + 30 * 60000);
            }
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

            // Jika slot tidak ada atau disabled (sudah dibooking/penuh)
            if (!slot || slot.classList.contains("pointer-events-none")) {
                return false;
            }
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
