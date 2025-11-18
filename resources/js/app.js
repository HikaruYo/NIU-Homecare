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
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

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
});

