import "./bootstrap";
import Swal from "sweetalert2";

// Check if there's a success or error message in the session
document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message");
    const errorMessage = document.getElementById("error-message");

    if (successMessage) {
        Swal.fire({
            title: "Success!",
            text: successMessage.textContent,
            icon: "success",
            confirmButtonText: "OK",
        });
    }

    if (errorMessage) {
        Swal.fire({
            title: "Error!",
            text: errorMessage.textContent,
            icon: "error",
            confirmButtonText: "OK",
        });
    }
});
