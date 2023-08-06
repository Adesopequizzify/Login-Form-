document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");  // Updated to use email input
    const passwordInput = document.getElementById("password");
    const passwordStrength = document.getElementById("password-strength");
    const loadingOverlay = document.getElementById("loading-overlay");
    const errorModal = document.getElementById("error-modal");
    const closeModalButton = document.getElementById("close-error-modal");
    const errorMessage = document.getElementById("error-message");

    passwordInput.addEventListener("input", function () {
        const password = passwordInput.value;
        const strength = calculatePasswordStrength(password);
        updatePasswordStrengthDisplay(strength);
    });

    closeModalButton.addEventListener("click", function () {
        errorModal.style.display = "none";
    });

    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        loadingOverlay.style.display = "flex";
        errorModal.style.display = "none";

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);

        xhr.onload = function () {
            loadingOverlay.style.display = "none";

            if (xhr.status >= 200 && xhr.status < 400) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Redirect to login-success.php and pass session data
                    const redirectURL = `index.php?session=${encodeURIComponent(response.session)}`;
                    window.location.href = redirectURL;
                } else {
                    errorMessage.textContent = response.message;
                    errorModal.style.display = "flex";
                }
            } else {
                errorMessage.textContent = "An error occurred. Please try again later.";
                errorModal.style.display = "flex";
            }
        };

        xhr.onerror = function () {
            loadingOverlay.style.display = "none";
            errorMessage.textContent = "An error occurred. Please try again later.";
            errorModal.style.display = "flex";
        };

        xhr.send(formData);
    });

    function calculatePasswordStrength(password) {
        if (password.length >= 8) {
            return "strong";
        } else {
            return "weak";
        }
    }

    function updatePasswordStrengthDisplay(strength) {
        passwordStrength.textContent = strength.charAt(0).toUpperCase() + strength.slice(1);
        passwordStrength.style.color = strength === "strong" ? "#2ecc71" : "#e74c3c";
    }
});