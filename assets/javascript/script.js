
const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle-form");
const main = document.querySelector("main");
var registrationForm = document.getElementById('registrationForm');
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");



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

let currentIndex = 1; // Start from the first bullet
const totalBullets = bullets.length;

function moveSlider(index) {
  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  bullets[index - 1].classList.add("active"); // Use index - 1 for zero-based index
}

function autoSlide() {
  currentIndex++;
  if (currentIndex > totalBullets) {
    currentIndex = 1; // Loop back to the first bullet
  }
  moveSlider(currentIndex);
}

// Set interval to change slides every 2 seconds (2000 ms)
setInterval(autoSlide, 5000);

// Add click event listeners to bullets
bullets.forEach((bullet) => {
  bullet.addEventListener("click", function() {
    currentIndex = this.dataset.value; // Update currentIndex on click
    moveSlider(currentIndex);
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

