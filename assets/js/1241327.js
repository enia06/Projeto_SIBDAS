const imagens = [
    "../assets/img/welcome 1.png",
    "../assets/img/welcome 2.png"
];

let imagemAtual = 0;

function imagemSeguinte() {
    imagemAtual++;
    if (imagemAtual >= imagens.length) {
        imagemAtual = 0;
    }
    
    document.getElementById("slider-image").src = imagens[imagemAtual];
}

function imagemAnterior() {
    imagemAtual--;
    if (imagemAtual < 0) {
        imagemAtual = imagens.length -1;
    }

    document.getElementById("slider-image").src = imagens[imagemAtual];
}


