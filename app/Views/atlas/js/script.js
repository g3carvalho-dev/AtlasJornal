// ========================================================
// CARROSSEL DE NOTÍCIAS - JORNAL ATLAS
// ========================================================

let currentSlideIndex = 0;
let carrosselTimer = null;
const TEMPO_SLIDE = 4000;

// Elementos do carrossel
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-indicators .dot');

// Exibe o slide selecionado
window.showSlide = function(index) {

    if (index >= slides.length) {
        currentSlideIndex = 0;
    } else if (index < 0) {
        currentSlideIndex = slides.length - 1;
    } else {
        currentSlideIndex = index;
    }

    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    if (slides[currentSlideIndex]) {
        slides[currentSlideIndex].classList.add('active');
    }

    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.add('active');
    }
};

// Navegação pelas setas
window.changeSlide = function(direction) {
    pararAutoplay();
    showSlide(currentSlideIndex + direction);
    iniciarAutoplay();
};

// Navegação pelas bolinhas
window.currentSlide = function(index) {
    pararAutoplay();
    showSlide(index);
    iniciarAutoplay();
};

// Inicia a troca automática de slides
function iniciarAutoplay() {
    if (!carrosselTimer) {
        carrosselTimer = setInterval(() => {
            showSlide(currentSlideIndex + 1);
        }, TEMPO_SLIDE);
    }
}

// Interrompe a troca automática
function pararAutoplay() {
    if (carrosselTimer) {
        clearInterval(carrosselTimer);
        carrosselTimer = null;
    }
}

// Inicialização do carrossel
iniciarAutoplay();