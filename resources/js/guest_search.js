document
    .getElementById("query_guest")
    .addEventListener("keyup", debounce(searchFaculty, 300));

document
    .getElementById("query_guest_active")
    .addEventListener("keyup", debounce(searchFacultyActive, 300));

document
    .getElementById("query_guest_inactive")
    .addEventListener("keyup", debounce(searchFacultyInactive, 300));

document
    .getElementById("query_guest_invalid")
    .addEventListener("keyup", debounce(searchFacultyInvalid, 300));

function searchFaculty() {
    let query_user = document.getElementById("query_guest").value;

    fetch("/admin/guestAccount/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_faculty: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("guest-table-body");
            tbody.innerHTML = "";
            data.forEach((user) => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.user_code}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.birthday}</td>
                    <td>${user.status}</td>
                    <td>
                        <a href="/admin/guestAccount/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/guestAccount/delete/${
                            user.id
                        }" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="${document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch((error) => console.error("Error:", error));
}

function searchFacultyActive() {
    let query_user = document.getElementById("query_guest_active").value;

    fetch("/admin/guestAccount/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_faculty: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("guest-active-table-body");
            tbody.innerHTML = "";
            data.filter((user) => user.status === "online").forEach((user) => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.user_code}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.birthday}</td>
                    <td>${user.status}</td>
                    <td>
                        <a href="/admin/guestAccount/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/guestAccount/delete/${
                            user.id
                        }" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="${document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch((error) => console.error("Error:", error));
}

function searchFacultyInactive() {
    let query_user = document.getElementById("query_guest_inactive").value;

    fetch("/admin/guestAccount/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_faculty: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("guest-inactive-table-body");
            tbody.innerHTML = "";
            data.filter((user) => user.status === "offline").forEach((user) => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.user_code}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.birthday}</td>
                    <td>${user.status}</td>
                    <td>
                        <a href="/admin/guestAccount/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/guestAccount/delete/${
                            user.id
                        }" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="${document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch((error) => console.error("Error:", error));
}
function searchFacultyInvalid() {
    let query_user = document.getElementById("query_faculty_invalid").value;

    fetch("/admin/invalidfaculty/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_faculty_invalid: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("faculty-invalid-table-body");
            tbody.innerHTML = "";
            data.forEach((user) => {
                let row = `<tr>
                <td>${user.id}</td>
                <td>${user.user_code}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.phone}</td>
                <td>${user.birthday}</td>
                <td>${user.status}</td>
                <td>${user.error_message}</td>
                <td>
                    <a href="/admin/invalidfaculty/edit/${
                        user.id
                    }" class="btn btn-warning btn-sm">Edit</a>
                    <form action="/admin/invalidfaculty/delete/${
                        user.id
                    }" method="POST" style="display:inline;">
                        <input type="hidden" name="_token" value="${document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch((error) => console.error("Error:", error));
}

function debounce(fn, delay) {
    let timeoutID;
    return function (...args) {
        if (timeoutID) {
            clearTimeout(timeoutID);
        }
        timeoutID = setTimeout(() => {
            fn(...args);
        }, delay);
    };
}
