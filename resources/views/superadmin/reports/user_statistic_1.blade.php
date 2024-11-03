<div>
    <div class="card card-round">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">User Activities Overview</div>
                <div class="card-tools">
                    <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                        <span class="btn-label">
                            <i class="fa fa-pencil"></i>
                        </span>
                        Export
                    </a>
                    <a href="#" class="btn btn-label-info btn-round btn-sm">
                        <span class="btn-label">
                            <i class="fa fa-print"></i>
                        </span>
                        Print
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <button id="dailyBtn" class="toggle-button">Daily</button>
                <button id="weeklyBtn" class="toggle-button">Weekly</button>
                <button id="monthlyBtn" class="toggle-button">Monthly</button>
            </div>
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
                    label: "Average Time Consumed (hr)",
                    borderColor: "#f3545d",
                    pointBackgroundColor: "rgba(243, 84, 93, 0.6)",
                    pointRadius: 0,
                    backgroundColor: "rgba(243, 84, 93, 0.4)",
                    fill: true,
                    borderWidth: 2,
                    data: [], // Average time data
                },
                {
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
            statisticsChart.data.labels = response.dates; // Set the labels for the x-axis
            statisticsChart.data.datasets[0].data = response.avg_time_consumed; // Avg time consumed
            statisticsChart.data.datasets[1].data = response.new_users; // New users
            statisticsChart.data.datasets[2].data = response.active_users; // Active users
            statisticsChart.update(); // Refresh the chart
        });
    }

    // Call the function to fetch and render data
    fetchUserStatistics();
</script>
