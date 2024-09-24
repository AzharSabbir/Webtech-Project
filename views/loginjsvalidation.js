document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");
    const emailError = document.createElement("span");
    const passwordError = document.createElement("span");

    // Styling for error messages
    emailError.style.color = "red";
    passwordError.style.color = "red";
    
    form.addEventListener("submit", function(event) {
        let isValid = true;

        // Reset error messages
        emailError.textContent = "";
        passwordError.textContent = "";

        // Validate email
        if (emailField.value.trim() === "") {
            emailError.textContent = "Please fill out the email.";
            emailField.parentNode.insertBefore(emailError, emailField.nextSibling);
            isValid = false;
        }

        // Validate password
        if (passwordField.value.trim() === "") {
            passwordError.textContent = "Please fill out the password.";
            passwordField.parentNode.insertBefore(passwordError, passwordField.nextSibling);
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
});
