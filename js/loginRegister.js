const container = document.getElementById('container');
const loginButton = document.getElementById('login');
const registerButton = document.getElementById('register');

registerButton.addEventListener('click', () => {
    container.classList.add("active");
})

loginButton.addEventListener('click', () => {
    container.classList.remove("active");
})