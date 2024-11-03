document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('form[id^="rating-form-"]').forEach((form) => {
        const imradId = form.querySelector('input[name="imrad_id"]').value;

        form.querySelectorAll('input[name="rating"]').forEach((radio) => {
            radio.addEventListener("change", function () {
                const selectedRating = form.querySelector(
                    'input[name="rating"]:checked'
                ).value;
                console.log(`Selected Rating: ${selectedRating}`);
                console.log(`IMRAD Metric ID: ${imradId}`);

                const formData = new FormData(form);

                fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": form.querySelector(
                            'input[name="_token"]'
                        ).value,
                    },
                    body: formData,
                })
                    .then((response) => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            console.error("Form submission failed.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            });
        });
    });
});
