const allCheckbox = document.getElementById("distributed_to_all");
const checkboxes = document.querySelectorAll(
    'input[name="distributed_to[]"]:not(#distributed_to_all)'
);

allCheckbox.addEventListener("change", function () {
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
    });
});

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        if (!this.checked) {
            allCheckbox.checked = false;
        } else {
            allCheckbox.checked = Array.from(checkboxes).every(
                (cb) => cb.checked
            );
        }
    });
});

// This is for time and date set Announcement
document.addEventListener("DOMContentLoaded", function () {
    const startInput = document.getElementById("start");
    const endInput = document.getElementById("end");

    const today = new Date().toISOString().slice(0, 16);
    startInput.min = today;

    startInput.addEventListener("input", function () {
        const startDate = new Date(startInput.value);
        const minEndDate = new Date(startDate.getTime() + 60000);
        endInput.min = minEndDate.toISOString().slice(0, 16);
    });

    endInput.addEventListener("input", function () {
        const startDate = new Date(startInput.value);
        const endDate = new Date(endInput.value);
        if (endDate <= startDate) {
            alert("End date must be at least one minute after the start date.");
            endInput.value = "";
        }
    });
});
