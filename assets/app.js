/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

const hamburgerBtn = document.querySelector(".hamburger-button");
const nav = document.querySelector(".header .center");
hamburgerBtn.addEventListener('click', () => {
    hamburgerBtn.classList.toggle('clicked');
    nav.classList.toggle('open');

})