<div>
    <div class="card card-round">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">User Activities Overview</div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-container" style="min-height: 375px;">
                <canvas id="statisticsChart"></canvas>
            </div>
            <div id="myChartLegend"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Initialize Chart.js
    var ctx = document.getElementById("statisticsChart").getContext("2d");
    var statisticsChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [], // This will be populated dynamically
            datasets: [{
                    label: "New Users",
                    borderColor: "#fdaf4b",
                    pointBackgroundColor: "rgba(253, 175, 75, 0.6)",
                    pointRadius: 0,
                    backgroundColor: "rgba(253, 175, 75, 0.4)",
                    fill: true,
                    borderWidth: 2,
                    data: [], // New users data
                },
                {
                    label: "Active Users",
                    borderColor: "#177dff",
                    pointBackgroundColor: "rgba(23, 125, 255, 0.6)",
                    pointRadius: 0,
                    backgroundColor: "rgba(23, 125, 255, 0.4)",
                    fill: true,
                    borderWidth: 2,
                    data: [], // Active users data
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    grid: {
                        drawTicks: false,
                        display: true,
                    },
                },
                x: {
                    grid: {
                        zeroLineColor: "transparent",
                    },
                },
            },
        },
    });

    // Function to fetch user statistics
    function fetchUserStatistics() {
        $.get("{{ route('superadmin.getDataUserStatistics') }}", function(response) {
            // Update the chart with the new data
            statisticsChart.data.labels = response.dates;
            statisticsChart.data.datasets[0].data = response.new_users;
            statisticsChart.data.datasets[1].data = response.active_users;
            statisticsChart.update();
        });
    }

    fetchUserStatistics();
</script>
