<div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Manuscript Downloads, Saves, Views and Average Ratings by SDG</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="sdgBarChart"></canvas>

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
        getData();
    });

    function getData() {
        $.ajax({
            url: '{{ route('admin.getData') }}', // Use Laravel route helper
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Define the list of all 17 SDGs
                var SDG_list = [
                    'No Poverty',
                    'Zero Hunger',
                    'Good Health and Well-being',
                    'Quality Education',
                    'Gender Equality',
                    'Clean Water and Sanitation',
                    'Affordable and Clean Energy',
                    'Decent Work and Economic Growth',
                    'Industry, Innovation and Infrastructure',
                    'Reduced Inequality',
                    'Sustainable Cities and Communities',
                    'Responsible Consumption and Production',
                    'Climate Action',
                    'Life Below Water',
                    'Life on Land',
                    'Peace, Justice and Strong Institutions',
                    'Partnerships for the Goals',
                ];

                // Initialize data arrays
                var sdgLabels = SDG_list; // Use SDG list for labels
                var downloadsData = new Array(SDG_list.length).fill(0);
                var savedData = new Array(SDG_list.length).fill(0);
                var viewsData = new Array(SDG_list.length).fill(0);
                var ratingsData = new Array(SDG_list.length).fill(0);

                // Map the response data to their respective indices
                response.sdgMetrics.forEach(function(metric) {
                    var index = sdgLabels.indexOf(metric.SDG);
                    if (index !== -1) {
                        downloadsData[index] = metric.downloads || 0; // Set downloads if available
                        savedData[index] = metric.saved || 0; // Set saves if available
                        viewsData[index] = metric.views || 0; // Set views if available
                        ratingsData[index] = metric.avg_rating || 0; // Set ratings if available
                    }
                });

                // Calculate the maximum value among downloads, saved, and views
                var maxDownloads = Math.max(...downloadsData);
                var maxSaved = Math.max(...savedData);
                var maxViews = Math.max(...viewsData);
                var dynamicMax = Math.max(maxDownloads, maxSaved, maxViews);

                // Set the maximum for y-axis dynamically (you can also add some padding)
                var yAxisMax = Math.ceil(dynamicMax * 1.1); // Add 10% buffer

                var ctx = document.getElementById("sdgBarChart").getContext("2d");

                // Create the bar chart
                var sdgBarChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: sdgLabels,
                        datasets: [{
                                label: "Downloads",
                                backgroundColor: "rgba(128, 0, 0, 0.75)", // SSU Maroon
                                borderColor: "rgba(128, 0, 0, 1)",
                                data: downloadsData,
                                borderRadius: 4,
                            },
                            {
                                label: "Views",
                                backgroundColor: "rgba(15, 118, 110, 0.75)", // Semantic Teal
                                borderColor: "rgba(15, 118, 110, 1)",
                                data: viewsData,
                                borderRadius: 4,
                            },
                            {
                                label: "Saved",
                                backgroundColor: "rgba(3, 105, 161, 0.75)", // Semantic Blue
                                borderColor: "rgba(3, 105, 161, 1)",
                                data: savedData,
                                borderRadius: 4,
                            },
                            {
                                label: "Rating",
                                backgroundColor: "rgba(212, 175, 55, 0.75)", // Academic Gold
                                borderColor: "rgba(212, 175, 55, 1)",
                                data: ratingsData,
                                borderRadius: 4,
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
                                    max: yAxisMax, // Set dynamic max
                                },
                                stacked: false,
                            }],
                        },
                        title: {
                            display: true,
                            text: "",
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
