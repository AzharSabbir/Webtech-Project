function isValid(form) {
  // Get the input fields and error span elements
  const email = form.email.value;
  const phone = form.phone.value;
  const gender = form.gender.value;
  const password = form.password.value;
  const confirmPassword = form.confirm_password.value;
  const registerAs = form.register_as.value;
  const username = form.username.value;

  const emailError = document.getElementById("emailerr");
  const phoneError = document.getElementById("phoneerr");
  const genderError = document.getElementById("gendererr");
  const passwordError = document.getElementById("passworderr");
  const confirmPasswordError = document.getElementById("confirmPassworderr");
  const registerAsError = document.getElementById("registeraserr");
  const usernameError = document.getElementById("usernameerr");

  // Clear previous error messages
  emailError.innerHTML = "";
  phoneError.innerHTML = "";
  genderError.innerHTML = "";
  passwordError.innerHTML = "";
  confirmPasswordError.innerHTML = "";
  registerAsError.innerHTML = "";
  usernameError.innerHTML = "";

  // Flag to track if the form is valid
  let isFormValid = true;

  // Check if username is empty
  if (username.trim() === "") {
    usernameError.innerHTML = "Username is required.";
    isFormValid = false;
  } else {
    // Username format validation using regex (3-20 characters, alphanumeric and underscores)
    const usernamePattern = /^[a-zA-Z0-9_]{3,20}$/;
    if (!usernamePattern.test(username)) {
      usernameError.innerHTML = "Invalid username. Only letters, numbers, and underscores allowed. Length: 3-20.";
      isFormValid = false;
    }
  }

  // Check if email is empty
  if (email.trim() === "") {
    emailError.innerHTML = "Email is required.";
    isFormValid = false;
  } else {
    // Email format validation using regex
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
      emailError.innerHTML = "Invalid email format.";
      isFormValid = false;
    }
  }

  // AJAX request to check if the email exists in the database
  if (email.trim() !== "") {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
      if (this.responseText === "exists") {
        emailError.innerHTML = "Email already exists.";
        isFormValid = false;
      }
    };
    xhttp.open("POST", "../controllers/CheckEmailExists.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + encodeURIComponent(email));
  }

  // Check if phone is empty
  if (phone.trim() === "") {
    phoneError.innerHTML = "Phone number is required.";
    isFormValid = false;
  }

  // Check if gender is selected
  if (gender.trim() === "") {
    genderError.innerHTML = "Gender is required.";
    isFormValid = false;
  }

  // Check if password is empty or less than 8 characters
  if (password.trim() === "") {
    passwordError.innerHTML = "Password is required.";
    isFormValid = false;
  } else if (password.length < 8) {
    passwordError.innerHTML = "Password must be at least 8 characters long.";
    isFormValid = false;
  }

  // Check if confirm password is empty
  if (confirmPassword.trim() === "") {
    confirmPasswordError.innerHTML = "Confirm Password is required.";
    isFormValid = false;
  }

  // Check if password and confirm password match
  if (password !== confirmPassword) {
    confirmPasswordError.innerHTML = "Passwords do not match.";
    isFormValid = false;
  }

  // Check if "Register as" is selected
  if (registerAs.trim() === "") {
    registerAsError.innerHTML = "Please select if you are registering as a student or mentor.";
    isFormValid = false;
  }

  // Return the validation result
  return isFormValid;
}
