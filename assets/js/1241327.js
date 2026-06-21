function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";

        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }

    else {
        password.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

const btnResumo = document.getElementById("btnResumo");
const btnDetalhe = document.getElementById("btnDetalhe");
const vistaResumo = document.getElementById("vistaResumo");
const vistaDetalhe = document.getElementById("vistaDetalhe");

if (btnResumo && btnDetalhe && vistaResumo && vistaDetalhe) {
    btnResumo.addEventListener("click", function () {
        vistaResumo.classList.remove("d-none");
        vistaDetalhe.classList.add("d-none");

        btnResumo.classList.add("active");
        btnDetalhe.classList.remove("active");
    });

    btnDetalhe.addEventListener("click", function () {
        vistaResumo.classList.add("d-none");
        vistaDetalhe.classList.remove("d-none");

        btnResumo.classList.remove("active");
        btnDetalhe.classList.add("active");
    });
}

function desenharGraficoCircular(idCanvas, dados, cores) {
    const canvas = document.getElementById(idCanvas);

    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    const total = dados.reduce((soma, valor) => soma + valor, 0);

    let anguloInicial = -0.5 * Math.PI;
    const centroX = canvas.width / 2;
    const centroY = canvas.height / 2;
    const raio = 90;

    dados.forEach((valor, index) => {
        const anguloFinal = anguloInicial + (valor / total) * 2 * Math.PI;

        ctx.beginPath();
        ctx.moveTo(centroX, centroY);
        ctx.arc(centroX, centroY, raio, anguloInicial, anguloFinal);
        ctx.closePath();
        ctx.fillStyle = cores[index];
        ctx.fill();

        anguloInicial = anguloFinal;
    });

    // círculo branco no meio para ficar tipo doughnut
    ctx.beginPath();
    ctx.arc(centroX, centroY, 45, 0, 2 * Math.PI);
    ctx.fillStyle = "white";
    ctx.fill();
}

desenharGraficoCircular(
    "graficoCategorias",
    [40, 30, 20, 10],
    ["#602323", "#a33c44", "#c9757b", "#ebcece"]
);

desenharGraficoCircular(
    "graficoLocalizacoes",
    [50, 30, 10, 10],
    ["#602323", "#a33c44", "#c9757b", "#ebcece"]
);


document.querySelectorAll(".btn-next-tab").forEach(function (button) {
    button.addEventListener("click", function () {
        const currentPane = button.closest(".tab-pane");
        const requiredFields = currentPane.querySelectorAll("[required]");
        let valid = true;

        requiredFields.forEach(function (field) {
            if (!field.value) {
                field.classList.add("is-invalid");
                valid = false;
            } else {
                field.classList.remove("is-invalid");
            }
        });

        if (!valid) {
            alert("Preencha todos os campos obrigatórios antes de avançar.");
            return;
        }

        const nextTabSelector = button.getAttribute("data-next");
        const nextTabButton = document.querySelector('[data-bs-target="' + nextTabSelector + '"]');

        if (nextTabButton) {
            nextTabButton.classList.remove("disabled");

            const tab = new bootstrap.Tab(nextTabButton);
            tab.show();
        }
    });
});

document.querySelectorAll(".btn-prev-tab").forEach(function (button) {
    button.addEventListener("click", function () {
        const prevTabSelector = button.getAttribute("data-prev");
        const prevTabButton = document.querySelector('[data-bs-target="' + prevTabSelector + '"]');

        if (prevTabButton) {
            const tab = new bootstrap.Tab(prevTabButton);
            tab.show();
        }
    });
});

