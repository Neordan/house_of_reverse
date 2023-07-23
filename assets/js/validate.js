  const inputs = document.querySelectorAll('input[type="password"]');
  const progressBar = document.getElementById("progress-bar");

  const errorDisplay = (tag, message, valid) => {
    const container = document.querySelector('.' + tag + '-container');
    const span = document.querySelector('.' + tag + '-container > span');
    if (!valid) {
      container.classList.add('error');
      span.textContent = message;
    } else {
      container.classList.remove('error');
      span.textContent = message;
    }
  };

  const checkPasswordStrength = (value) => {
    const hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(value);
    const hasNumber = /\d/.test(value);

    if (value.length < 8) {
      errorDisplay("password", "Le mot de passe doit contenir au moins 8 caractères", false);
      progressBar.style.width = "25%";
      progressBar.style.backgroundColor = "#FF0000";
    } else if (value.length < 12 || !hasSymbol || !hasNumber) {
      errorDisplay("password", "Le mot de passe doit contenir au moins 12 caractères, un symbole et un chiffre", false);
      progressBar.style.width = "50%";
      progressBar.style.backgroundColor = "#FFA500";
    } else {
      errorDisplay("password", "", true);
      progressBar.style.width = "100%";
      progressBar.style.backgroundColor = "#00FF00";
    }
  };

  const passwordChecker = (value) => {
    const password = document.getElementById("password").value;
    if (!password.match(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\W]).{8,}$/)) {
        errorDisplay(
            "password",
            "Le mot de passe doit faire au moins 8 caractères, contenir une majuscule, une minuscule, un chiffre et un caractère spécial",
            false
        );
        progressBar.classList.remove("progressBlue");
        progressBar.classList.remove("progressGreen");
        progressBar.classList.add("progressRed");
        password = null;
    } else if (password.length < 12) {
        progressBar.classList.remove("progressRed");
        progressBar.classList.remove("progressGreen");
        progressBar.classList.add("progressBlue");
        errorDisplay("password", "", true);
        password = value;
    } else {
        progressBar.classList.remove("progressRed");
        progressBar.classList.remove("progressBlue");
        progressBar.classList.add("progressGreen");
        errorDisplay("password", "", true);
        password = value;
    }
    if(confirmPass) confirmChecker(confirmPass)
};

  const confirmChecker = (value) => {
    const password = document.getElementById("password").value;
    if (value !== password) {
      errorDisplay("confirm", "Les mots de passe ne correspondent pas", false);
    } else {
      errorDisplay("confirm", "", true);
    }
  };

  inputs.forEach((input) => {
    input.addEventListener("input", (e) => {
      switch (e.target.id) {
        case "password":
          checkPasswordStrength(e.target.value);
          break;
        case "hash_mdp2":
          confirmChecker(e.target.value);
          break;
        default:
          break;
      }
    });
  });
