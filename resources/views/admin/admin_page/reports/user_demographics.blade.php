<div>
    <div class="card card-round">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">User Demographics</div>
                {{-- <div class="card-tools">
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
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <select id="demographicFilter" class="form-control mb-3">
                <option value="gender">Gender</option>
                <option value="ageRange">Age Range</option>
                <option value="userRole">User Role</option>
            </select>
            <div class="chart-container" style="min-height: 375px;">
                <canvas id="demographicsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Chart.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById("demographicsChart").getContext("2d");
    var demographicsChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
            },
        },
    });

    function fetchDemographicData(category) {
        $.get("{{ route('admin.getUserDemographics') }}", {
            filter: category
        }, function(response) {
            let labels, data, backgroundColor;

            switch (category) {
                case 'gender':
                    labels = ['Male', 'Female', 'Other'];
                    data = [response.gender.male, response.gender.female, response.gender.other];
                    backgroundColor = ['#0369a1', '#800000', '#cbd5e1']; // Info Blue, Brand Maroon, Slate 300
                    break;

                case 'ageRange':
                    labels = ['Not Specified', '13 - 19', '20 - 34', '35 - 49', '50+'];
                    data = [
                        response.age['null'],
                        response.age['13 - 19'],
                        response.age['20 - 34'],
                        response.age['35 - 49'],
                        response.age['50+'],
                    ];
                    backgroundColor = ['#94a3b8', '#fecdd3', '#800000', '#d4af37', '#1f2937']; // Slate 400, Rose 200, Maroon, Gold, Dark Slate
                    break;

                case 'userRole':
                    labels = ['Admin', 'User'];
                    data = [response.user.admin, response.user.user];
                    backgroundColor = ['#800000', '#d4af37']; // Maroon, Gold
                    break;

                default:
                    return;
            }

            demographicsChart.data.labels = labels;
            demographicsChart.data.datasets[0].data = data;
            demographicsChart.data.datasets[0].backgroundColor = backgroundColor;
            demographicsChart.update();
        });
    }

    document.getElementById("demographicFilter").addEventListener("change", function() {
        fetchDemographicData(this.value);
    });

    fetchDemographicData("gender"); // Fetch default data for initial load
</script>
