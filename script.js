const button = document.getElementById("subiiiuuuuu");

function scrollar() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

window.onscroll = function () {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        button.classList.add('show'); // Adiciona a classe show para tornar o botão visível
        button.classList.remove('hide'); // Remove a classe hide se estiver presente
    } else {
        button.classList.add('hide'); // Adiciona a classe hide quando o botão for ocultado
        button.classList.remove('show'); // Remove a classe show se estiver presente
    }

    adjustButtonPosition();
};

function adjustButtonPosition() {
    const footer = document.querySelector('footer');
    const footerPosition = footer ? footer.getBoundingClientRect().top : 0;
    const buttonHeight = button.offsetHeight;

    if (footerPosition - window.innerHeight <= buttonHeight) {
        button.style.position = 'absolute';
        button.style.bottom = `${footerPosition - window.innerHeight + 10}px`;
    } else {
        button.style.position = 'fixed';
        button.style.bottom = '20px';
    }
}
