const loginForm = document.querySelector(".form-box.login");
const signupForm = document.querySelector(".form-box.signup");
const signupLink = document.querySelector(".Register.Link");
const loginLink = document.querySelectorAll(".login-register a")[1];

signupLink.addEventListener("click", () => {
  loginForm.style.display = "none";
  signupForm.style.display = "block";
});

loginLink.addEventListener("click", () => {
  signupForm.style.display = "none";
  loginForm.style.display = "block";
});
