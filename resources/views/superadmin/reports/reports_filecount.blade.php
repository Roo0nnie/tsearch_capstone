<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Number of File Uploads Per Month</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function fetchUploadData() {
        try {
            const response = await fetch("{{ route('superadmin.filecount') }}");
            const data = await response.json();

            if (data && data.uploads) {
                renderChart(data.uploads);
            } else {
                console.error("Invalid data format received.");
            }
        } catch (error) {
            console.error("Error fetching upload data:", error);
        }
    }

    function renderChart(uploadCounts) {
        var lineChart = document.getElementById("lineChart").getContext("2d");
        var myLineChart = new Chart(lineChart, {
            type: "line",
            data: {
                labels: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ],
                datasets: [{
                    label: "File Uploads",
                    borderColor: "#1d7af3",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#1d7af3",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: "rgba(29, 122, 243, 0.2)",
                    fill: true,
                    borderWidth: 2,
                    data: uploadCounts,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                    labels: {
                        padding: 10,
                        fontColor: "#1d7af3",
                    },
                },
                tooltips: {
                    bodySpacing: 4,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest",
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10,
                },
                layout: {
                    padding: {
                        left: 15,
                        right: 15,
                        top: 15,
                        bottom: 15
                    },
                },
            },
        });
    }

    fetchUploadData();
</script>
