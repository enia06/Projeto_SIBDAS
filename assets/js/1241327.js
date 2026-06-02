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