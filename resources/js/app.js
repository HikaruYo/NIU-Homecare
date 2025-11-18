import './bootstrap';
import flatpickr from "flatpickr";

import {
    Ripple,
    initTWE,
} from "tw-elements";

initTWE({ Ripple });

const mybutton = document.getElementById("btn-back-to-top");

if (mybutton) {
    const scrollFunction = () => {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            mybutton.classList.remove("hidden");
        } else {
            mybutton.classList.add("hidden");
        }
    };
    const backToTop = () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

    mybutton.addEventListener("click", backToTop);
    window.addEventListener("scroll", scrollFunction);
}


// Animation for Calender
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


// Logic for hidden/visible password
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


// Pop-up after register
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

}, 7000);
