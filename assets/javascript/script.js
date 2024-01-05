const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle-form");
const main = document.querySelector("main");
var registrationForm = document.getElementById('registrationForm');

//Efeitos gerais dos input fields e labels
inputs.forEach(inp => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });

});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    event.preventDefault();
    main.classList.toggle("sign-up-mode");
  });
});

//-------------------------------------------------//--------------------------------------------//


//Trata a confirmação da senha

function checarSenha() {
  let password = document.getElementById("password").value;
  let confPassword = document.getElementById("conf-password").value;
  let message = document.getElementById("confirmar_senha");

  if (password !== confPassword) {
    // Aplica efeito fade-in na mensagem de erro
    message.style.opacity = 1;
    message.textContent = "Senha não coincide";
    message.style.backgroundColor = "#ff4d4d";

    // Faz com que a mensagem de erro desapareça após 2 segundos.
    setTimeout(function () {
      // Aplica efeito de fade-out
      message.style.opacity = 0;
      setTimeout(function () {
        message.textContent = "";
        message.style.backgroundColor = "";
      }, 500); // Tempo de espera para a conclusão do efeito fade-out (0.5s)
    }, 2000);

    return false; // Retorna false, indicando que a senha não coincide.
  } else {
    // Reseta a mensagem de erro
    message.textContent = "";
    message.style.backgroundColor = "";
    return true; // Retorna true, indicando que a senha coincide.
  }
}

//Previne que a tela atualize sozinha após inserir a senha incorreta
registrationForm.addEventListener('submit', function (event) {
  if (!checarSenha()) {
    event.preventDefault(); 
  }
});

//-----------------------------------------------//----------------------------------------------------//

