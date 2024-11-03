document
    .getElementById("submit-button")
    .addEventListener("click", function (event) {
        const authorChecks = document.querySelectorAll(
            'input[name="authors[]"]:checked'
        ).length;
        const adviserChecks = document.querySelectorAll(
            'input[name="advisers[]"]:checked'
        ).length;
        const departmentChecks = document.querySelectorAll(
            'input[name="departments[]"]:checked'
        ).length;

        const totalChecks = authorChecks + adviserChecks + departmentChecks;

        if (totalChecks > 10) {
            alert("You can only select up to 10 items in total.");
            event.preventDefault();
        }
    });
