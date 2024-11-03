<div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Social Development Goal - File Counts</div>
                        <div class="card-tools">
                            <a href="#" id="exportChart" class="btn btn-label-success btn-round btn-sm me-2">
                                <span class="btn-label">
                                    <i class="fa fa-pencil"></i>
                                </span>
                                Export Image
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="sdgLineChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        createLineChart();
    });

    function createLineChart() {
        $.ajax({
            url: '{{ route('admin.getDatalinegraph') }}',
            type: 'GET',
            success: function(response) {
                var sdgLabels = response.sdgMetrics.map(function(item) {
                    return item.sdg;
                });

                var fileCounts = response.sdgMetrics.map(function(item) {
                    return item.count;
                });

                var ctx = document.getElementById("sdgLineChart").getContext("2d");

                var sdgLineChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: sdgLabels,
                        datasets: [{
                            label: "File Counts",
                            backgroundColor: "rgba(75, 192, 192, 0.5)",
                            borderColor: "rgba(75, 192, 192, 1)",
                            data: fileCounts,
                            fill: false,
                        }],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Sustainable Development Goals (SDGs)'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'File Counts'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: "Number of Files Associated with Each SDG"
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching SDG data:', error);
            }
        });
    }

    // Export the chart as an image
    document.getElementById('exportChart').addEventListener('click', function() {
        var url_base64jp = document.getElementById('sdgLineChart').toDataURL("image/png");
        var link = document.createElement('a');
        link.href = url_base64jp;
        link.download = 'sdg_line_chart.png';
        link.click();
    });
</script>
