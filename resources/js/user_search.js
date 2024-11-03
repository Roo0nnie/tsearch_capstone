document.getElementById("query_user").addEventListener("keyup", searchUser);
document
    .getElementById("query_user_active")
    .addEventListener("keyup", searchUserActive);
document
    .getElementById("query_user_deactive")
    .addEventListener("keyup", searchUserDeactive);

document
    .getElementById("query_user_invalid")
    .addEventListener("keyup", debounce(searchUserInvalid, 300));

function searchUserActive() {
    let query_user = document.getElementById("query_user_active").value;

    fetch("/admin/user/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_user: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("userActive-table-body");
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
                        <a href="/admin/userinvalid/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/userinvalid/delete/${
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

function searchUserDeactive() {
    let query_user = document.getElementById("query_user_deactive").value;

    fetch("/admin/user/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_user: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("userDeactive-table-body");
            tbody.innerHTML = "";
            // Filter deactive users
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
                        <a href="/admin/user/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/user/delete/${
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

function searchUser() {
    let query_user = document.getElementById("query_user").value;

    fetch("/admin/user/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_user: query_user }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("user-table-body");
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
                        <a href="/admin/user/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/user/delete/${
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

function searchUserInvalid() {
    let query_user = document.getElementById("query_user_invalid").value;

    fetch("/admin/invaliduser/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_user_invalid: query_user }), // Adjust for user search
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("user-invalid-table-body"); // Assuming table ID for user invalid
            tbody.innerHTML = ""; // Clear the existing rows
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
                        <a href="/admin/userinvalid/edit/${
                            user.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/userinvalid/delete/${
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
