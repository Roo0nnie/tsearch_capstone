<div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category ">User Last 7 days</p>
                                <h4 class="card-title">
                                    {{ count($logusers) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Users</p>
                                <h4 class="card-title">{{ count($users) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-luggage-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Files</p>
                                <h4 class="card-title">{{ count($imrads) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Recently Added Files</p>
                                <h4 class="card-title">
                                    {{ $imrads->filter(fn($imrad) => $imrad->created_at >= now()->subDay())->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-body skew-shadow">
                    <h1>{{ $users->filter(fn($user) => $user->status === 'Active')->count() }}</h1>
                    <h5 class="op-8">Users Today</h5>
                    <div class="pull-right">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-secondary bg-secondary-gradient">
                <div class="card-body bubble-shadow">
                    <h1>{{ count($imrads) }}</h1>
                    <h5 class="op-8">Published Files</h5>
                    <div class="pull-right">
                        <i class="fa-solid fa-book fa-2x"></i>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        getDate();
        /
    });

    function getDate() {
        $.ajax({
            url: '{{ route('superadmin.getData') }}',
            method: 'GET',
            dataType: 'json',
            success: function(response) {

                var sdgLabels = [];
                var downloadsData = [];
                var savedData = [];
                var ratingsData = [];
                var viewsData = [];

                response.sdgMetrics.forEach(function(metric) {
                    sdgLabels.push(metric.SDG);
                    downloadsData.push(metric.downloads);
                    savedData.push(metric.saved);
                    viewsData.push(metric.views);
                    ratingsData.push(metric.avg_rating);
                });

                var ctx = document.getElementById("sdgBarChart").getContext("2d");

                // Create the bar chart
                var sdgBarChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: sdgLabels,
                        datasets: [{
                                label: "Downloads",
                                backgroundColor: "rgba(75, 192, 192, 0.7)", // Teal
                                borderColor: "rgba(75, 192, 192, 1)",
                                data: downloadsData,
                            },
                            {
                                label: "Views",
                                backgroundColor: "rgba(255, 99, 132, 0.7)", // Red
                                borderColor: "rgba(255, 99, 132, 1)",
                                data: viewsData,
                            },
                            {
                                label: "Saved",
                                backgroundColor: "rgba(54, 162, 235, 0.7)", // Blue
                                borderColor: "rgba(54, 162, 235, 1)",
                                data: savedData,
                            },
                            {
                                label: "Rating",
                                backgroundColor: "rgba(255, 206, 86, 0.7)", // Yellow
                                borderColor: "rgba(255, 206, 86, 1)",
                                data: ratingsData,
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                stacked: false,
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    max: 100,
                                },
                                stacked: false,
                            }],
                        },
                        title: {
                            display: true,
                            text: "Manuscript Downloads, Saves, Views and Average Ratings by SDG",
                        },
                    },
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", error);
            }
        });
    }
</script>
