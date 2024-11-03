document.getElementById("query_imrad").addEventListener("keyup", searchImrad);
document
    .getElementById("query_archive")
    .addEventListener("keyup", searchArchive);
document.getElementById("query_temp").addEventListener("keyup", searchTemp);

function searchImrad() {
    let query_imrad = document.getElementById("query_imrad").value;

    fetch("/admin/imrad/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_imrad: query_imrad }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("imrad-table-body");
            tbody.innerHTML = "";
            data.forEach((imrad) => {
                let row = `<tr>
                    <td>${imrad.id}</td>
                    <td>${imrad.title}</td>
                    <td>${imrad.author}</td>
                    <td>${imrad.adviser}</td>
                    <td>${imrad.department}</td>
                    <td>${imrad.abstract}</td>
                    <td>${imrad.publisher}</td>
                    <td>${imrad.publication_date}</td>
                    <td>${imrad.keywords}</td>
                    <td>${imrad.location}</td>
                    <td>${imrad.awards}</td>
                    <td>${imrad.pdf_file}</td>
                    <td>
                        <a href="/admin/imrad/edit/${
                            imrad.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/imrad/delete/${
                            imrad.id
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

function searchTemp() {
    let query_temp = document.getElementById("query_temp").value;

    fetch("/admin/temp/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_temp: query_temp }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("temp-table-body");
            tbody.innerHTML = "";
            data.forEach((imrad) => {
                let row = `<tr>
                    <td>${imrad.id}</td>
                    <td>${imrad.title}</td>
                    <td>${imrad.author}</td>
                    <td>${imrad.adviser}</td>
                    <td>${imrad.department}</td>
                    <td>${imrad.abstract}</td>
                    <td>${imrad.publisher}</td>
                    <td>${imrad.publication_date}</td>
                    <td>${imrad.keywords}</td>
                    <td>${imrad.location}</td>
                    <td>${imrad.awards}</td>
                    <td>${imrad.pdf_file}</td>
                    <td>
                        <a href="/admin/imrad/edit/${
                            imrad.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/imrad/delete/${
                            imrad.id
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

function searchArchive() {
    let query_archive = document.getElementById("query_archive").value;

    fetch("/admin/archive/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ query_archive: query_archive }),
    })
        .then((response) => response.json())
        .then((data) => {
            let tbody = document.getElementById("archive-table-body");
            tbody.innerHTML = "";
            data.forEach((imrad) => {
                let row = `<tr>
                    <td>${imrad.id}</td>
                    <td>${imrad.title}</td>
                    <td>${imrad.author}</td>
                    <td>${imrad.adviser}</td>
                    <td>${imrad.department}</td>
                    <td>${imrad.abstract}</td>
                    <td>${imrad.publisher}</td>
                    <td>${imrad.publication_date}</td>
                    <td>${imrad.keywords}</td>
                    <td>${imrad.location}</td>
                    <td>${imrad.awards}</td>
                    <td>${imrad.pdf_file}</td>
                    <td>
                        <a href="/admin/imrad/edit/${
                            imrad.id
                        }" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/admin/imrad/delete/${
                            imrad.id
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
