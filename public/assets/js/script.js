// ========================================================
// CARROSSEL DE NOTÍCIAS - JORNAL ATLAS
// ========================================================

let currentSlideIndex = 0;
let carrosselTimer = null;
const TEMPO_SLIDE = 4000;

const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.carousel-indicators .dot');

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

window.changeSlide = function(direction) {
    pararAutoplay();
    showSlide(currentSlideIndex + direction);
    iniciarAutoplay();
};

window.currentSlide = function(index) {
    pararAutoplay();
    showSlide(index);
    iniciarAutoplay();
};

function iniciarAutoplay() {
    if (slides.length > 0 && !carrosselTimer) {
        carrosselTimer = setInterval(() => {
            showSlide(currentSlideIndex + 1);
        }, TEMPO_SLIDE);
    }
}

function pararAutoplay() {
    if (carrosselTimer) {
        clearInterval(carrosselTimer);
        carrosselTimer = null;
    }
}

iniciarAutoplay();

// ========================================================
// MODO ESCURO / VOLTAR AO TOPO
// ========================================================

const TEMA_STORAGE_KEY = 'atlas-tema';

function aplicarTema(tema) {
    const temaEscuro = tema === 'escuro';
    document.body.classList.toggle('tema-escuro', temaEscuro);

    const botaoTema = document.querySelector('.theme-toggle');
    if (botaoTema) {
        botaoTema.innerHTML = temaEscuro
            ? '<i class="fa-solid fa-sun"></i>'
            : '<i class="fa-solid fa-moon"></i>';
        botaoTema.setAttribute('aria-label', temaEscuro ? 'Ativar modo claro' : 'Ativar modo escuro');
        botaoTema.setAttribute('title', temaEscuro ? 'Modo claro' : 'Modo escuro');
    }
}

function criarControlesFlutuantes() {
    const controles = document.createElement('div');
    controles.className = 'floating-actions';
    controles.innerHTML = `
        <button type="button" class="theme-toggle" aria-label="Alternar tema" title="Alternar tema"></button>
        <button type="button" class="back-to-top" aria-label="Voltar ao topo" title="Voltar ao topo">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    `;

    document.body.appendChild(controles);

    const temaSalvo = localStorage.getItem(TEMA_STORAGE_KEY) || 'claro';
    aplicarTema(temaSalvo);

    controles.querySelector('.theme-toggle').addEventListener('click', () => {
        const proximoTema = document.body.classList.contains('tema-escuro') ? 'claro' : 'escuro';
        localStorage.setItem(TEMA_STORAGE_KEY, proximoTema);
        aplicarTema(proximoTema);
    });

    const botaoTopo = controles.querySelector('.back-to-top');
    window.addEventListener('scroll', () => {
        botaoTopo.classList.toggle('visible', window.scrollY > 350);
    });

    botaoTopo.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// ========================================================
// COMPARTILHAR
// ========================================================

function copiarTexto(texto) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(texto);
    }

    const input = document.createElement('input');
    input.value = texto;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    input.remove();

    return Promise.resolve();
}

function configurarCompartilhamento() {
    document.querySelectorAll('.btn-compartilhar').forEach((botao) => {
        botao.addEventListener('click', async () => {
            const titulo = botao.dataset.shareTitle || document.title;
            const link = window.location.href;

            if (navigator.share) {
                try {
                    await navigator.share({ title: titulo, url: link });
                    return;
                } catch (erro) {
                    if (erro.name === 'AbortError') {
                        return;
                    }
                }
            }

            await copiarTexto(link);
            const textoOriginal = botao.innerHTML;
            botao.innerHTML = '<i class="fa-solid fa-check"></i> Link copiado';

            setTimeout(() => {
                botao.innerHTML = textoOriginal;
            }, 1800);
        });
    });
}

// ========================================================
// BUSCA NOS CARDS E NEWSLETTER
// ========================================================

document.addEventListener('DOMContentLoaded', () => {
    criarControlesFlutuantes();
    configurarCompartilhamento();

    const searchInput = document.querySelector('.search-box input');
    const cardItems = document.querySelectorAll('.card-wrapper, .cards > .card-link');

    if (searchInput && cardItems.length > 0) {
        const cardsContainer = cardItems[0].closest('.cards');
        const emptyMessage = document.createElement('p');
        emptyMessage.className = 'busca-vazia';
        emptyMessage.textContent = 'Nenhuma notícia encontrada para essa busca.';
        emptyMessage.style.display = 'none';

        if (cardsContainer && cardsContainer.parentNode) {
            cardsContainer.parentNode.insertBefore(emptyMessage, cardsContainer.nextSibling);
        }

        searchInput.addEventListener('input', () => {
            const termo = searchInput.value.trim().toLowerCase();
            let encontrados = 0;

            cardItems.forEach((item) => {
                const texto = item.textContent.toLowerCase();
                const visivel = termo === '' || texto.includes(termo);

                item.style.display = visivel ? '' : 'none';
                if (visivel) {
                    encontrados++;
                }
            });

            emptyMessage.style.display = encontrados === 0 ? 'block' : 'none';
        });
    }

    document.querySelectorAll('.newsletter-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const input = form.querySelector('input[type="email"]');
            let feedback = form.parentElement.querySelector('.newsletter-feedback');

            if (!feedback) {
                feedback = document.createElement('p');
                feedback.className = 'newsletter-feedback';
                form.insertAdjacentElement('afterend', feedback);
            }

            feedback.textContent = `Pronto! ${input.value} foi cadastrado na newsletter.`;
            form.reset();
        });
    });

    document.querySelectorAll('.contato-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            let feedback = form.querySelector('.contato-feedback');
            if (!feedback) {
                feedback = document.createElement('p');
                feedback.className = 'contato-feedback';
                form.appendChild(feedback);
            }

            feedback.textContent = 'Mensagem enviada! Em um projeto real, ela seria encaminhada para a equipe.';
            form.reset();
        });
    });
});
