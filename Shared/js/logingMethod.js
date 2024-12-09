function toggleForms() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const toggleToRegister = document.getElementById('toggleToRegister');
    const toggleToLogin = document.getElementById('toggleToLogin');

    loginForm.classList.toggle('d-none');
    registerForm.classList.toggle('d-none');

    // Mostrar el botón correspondiente
    if (loginForm.classList.contains('d-none')) {
        toggleToLogin.style.display = 'block';
        toggleToRegister.style.display = 'none';
    } else {
        toggleToLogin.style.display = 'none';
        toggleToRegister.style.display = 'block';
    }
}

// Inicializar el estado de los botones al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const toggleToRegister = document.getElementById('toggleToRegister');
    const toggleToLogin = document.getElementById('toggleToLogin');

    if (loginForm.classList.contains('d-none')) {
        toggleToLogin.style.display = 'block';
    } else {
        toggleToRegister.style.display = 'block';
    }
});