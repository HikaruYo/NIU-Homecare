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


// Memunculkan/menghilangkan status alert buatan
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
            const opt = select.selectedOptions[0];

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
                for (let m = 30; m <= 180; m += 30) { // Membatasi maksimal layanan fleksibel hingga 3 jam
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
        });
    }

    // Init Event untuk baris pertama
    document.querySelectorAll("#layanan-wrapper > .layanan-row").forEach(row => attachEventToRow(row));


    // Logic untuk memilih slot jadwal
    function resetSlotSelection() {
        // Fungsi helper untuk clear slot jika layanan berubah
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

            // Kalkulasi waktu selesai
            const [h, m] = start.split(":").map(Number);
            const startDate = new Date(2000, 1, 1, h, m);
            const endDate = new Date(startDate.getTime() + totalDurasi * 60000);
            const end = endDate.toTimeString().slice(0,5);

            // Cek ketersediaan slot
            if (!cekSlotAvailable(start, end)) {
                alert("Durasi layanan melebihi slot waktu yang tersedia.");
                return;
            }

            // Update Tampilan UI
            document.querySelector("#start_time").value = start;
            document.querySelector("#end_time").value = end;
            document.querySelector("#displayStart").textContent = start;
            // Fix selector duplicate ID (ambil elemen kedua/end)
            const displays = document.querySelectorAll("#displayStart");
            if(displays.length > 1) displays[1].textContent = end;

            // Highlight Slot
            slotItems.forEach(s => s.classList.remove("bg-mainColor", "text-white"));
            item.classList.add("bg-mainColor", "text-white");

            // Memastikan input slot ada (agar dapat mengirim data ke DB)
            if (!slotsContainer) {
                console.error("Container #selected-slots-container tidak ditemukan di HTML!");
                return;
            }

            // Bersihkan input lama
            slotsContainer.innerHTML = "";

            let menitTemp = start;
            let loopDate = new Date(startDate);
            const finalDate = new Date(endDate);

            // Loop untuk membuat input slot hidden (agar dapat mengirim data ke DB) per 30 menit
            while (loopDate < finalDate) {
                const timeStr = loopDate.toTimeString().slice(0, 5); // Format HH:mm

                // Cari elemen slot di UI yang cocok waktunya
                const slotEl = document.querySelector(`.slot-item[data-time='${timeStr}']`);

                if (slotEl) {
                    // Ambil ID slot dari data-id (components/jadwal.blade.php)
                    const slotId = slotEl.dataset.id;

                    // Buat input hidden dan mengirim data ke Controller
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "slot_jadwal_id[]";
                    input.value = slotId;

                    slotsContainer.appendChild(input);
                }

                // Tambah 30 menit
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
