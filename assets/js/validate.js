// Fonction pour afficher le message d'erreur sous un champ
const displayErrorMessage = (input, message) => {
  const errorContainer = input.parentElement.querySelector('.error-message');
  errorContainer.textContent = message;
};

// Fonction pour valider l'e-mail
const validateEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
};

// Fonction pour valider le mot de passe
const validatePassword = (password) => {
  const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;
  return passwordRegex.test(password);
};

// Fonction pour valider la confirmation du mot de passe
const validatePasswordConfirmation = (password, confirmPassword) => {
  return password === confirmPassword;
};

document.addEventListener('DOMContentLoaded', () => {
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm');

  emailInput.addEventListener('input', () => {
    const email = emailInput.value;
    const isValid = validateEmail(email);
    if (isValid) {
      displayErrorMessage(emailInput, '');
    } else {
      displayErrorMessage(emailInput, 'L\'e-mail n\'est pas valide');
    }
  });

  passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const isValid = validatePassword(password);
    if (isValid) {
      displayErrorMessage(passwordInput, '');
    } else {
      displayErrorMessage(passwordInput, 'Le mot de passe doit contenir au moins 6 caractères, un caractère spécial et un chiffre');
    }
  });

  confirmPasswordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const isValid = validatePasswordConfirmation(password, confirmPassword);
    if (isValid) {
      displayErrorMessage(confirmPasswordInput, '');
    } else {
      displayErrorMessage(confirmPasswordInput, 'Les mots de passe ne correspondent pas');
    }
  });
});
