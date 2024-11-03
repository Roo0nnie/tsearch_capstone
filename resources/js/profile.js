document.getElementById("currpass").onkeyup = function () {
    validateCurrentPassword();
};

function validateCurrentPassword() {
    let currPass = document.getElementById("currpass").value;
    let userCode = document
        .getElementById("currpass")
        .getAttribute("data-user");

    let passCode = document.getElementById("passcode").value;

    let url;
    if (passCode.startsWith("20")) {
        url = `/home/faculty/passwordcheck/${userCode}`;
    } else if (passCode.startsWith("09")) {
        url = `/guest/account/passwordcheck/${userCode}`;
    } else if (passCode.startsWith("21")) {
        url = `/home/passwordcheck/${userCode}`;
    } else {
        url = `/admin/passwordcheck/${userCode}`;
    }

    let passwordField = document.getElementById("password1");
    let passConfirm = document.getElementById("password-confirm1");

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            currPass: currPass,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.valid) {
                document
                    .getElementById("currpass")
                    .classList.remove("is-invalid");
                document.getElementById("currpass-error").style.display =
                    "none";
                passwordField.removeAttribute("readonly");
                passConfirm.removeAttribute("readonly");
                passwordField.setAttribute("type", "password");
                passConfirm.setAttribute("type", "password");
            } else {
                document.getElementById("currpass").classList.add("is-invalid");
                document.getElementById("currpass-error").style.display =
                    "block";
                passwordField.setAttribute("readonly", true);
                passConfirm.setAttribute("readonly", true);
                passwordField.setAttribute("type", "text");
                passConfirm.setAttribute("type", "text");
            }
        })
        .catch((error) => console.error("Error:", error));
}
