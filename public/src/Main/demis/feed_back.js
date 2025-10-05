const button = document.querySelector(".show-feedback");
const feedbackForm = document.querySelector(".feedback-form");

if (button) {
  button.addEventListener("click", function () {
    button.style.display = "none";
    feedbackForm.style.display = "block";
  });
}
