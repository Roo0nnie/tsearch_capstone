"use strict";

// Example Circular progress for SDG completion
Circles.create({
    id: "sdg-progress",
    radius: 50,
    value: 80, // Example SDG completion percentage
    maxValue: 100,
    width: 5,
    text: function (value) {
        return value + "%"; // Display SDG completion percentage
    },
    colors: ["#28a745", "#fff"], // Green color for progress
    duration: 400,
    wrpClass: "circles-wrp",
    textClass: "circles-text",
    styleWrapper: true,
    styleText: true,
});

var ctx = document.getElementById("sdgChart").getContext("2d");

var sdgChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "No Poverty",
            "Zero Hunger",
            "Good Health",
            "Quality Education",
            "Gender Equality",
            "Clean Water",
            "Affordable Energy",
            "Decent Work",
            "Industry Innovation",
            "Reduced Inequality",
            "Sustainable Cities",
            "Responsible Consumption",
            "Climate Action",
            "Life Below Water",
            "Life on Land",
            "Peace & Justice",
            "Partnerships",
        ], // SDG Goals as labels
        datasets: [
            {
                label: "Progress Towards Goals",
                borderColor: "#36a3f7", // Blue for general progress
                pointBackgroundColor: "rgba(54, 163, 247, 0.6)",
                pointRadius: 4,
                backgroundColor: "rgba(54, 163, 247, 0.2)",
                legendColor: "#36a3f7",
                fill: true,
                borderWidth: 2,
                data: [
                    70, 65, 85, 75, 60, 55, 90, 80, 50, 45, 40, 70, 60, 50, 65,
                    75, 200,
                ], // Example SDG completion data
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: true,
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
            padding: { left: 5, right: 5, top: 15, bottom: 15 },
        },
        scales: {
            yAxes: [
                {
                    ticks: {
                        fontStyle: "500",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 10,
                    },
                    gridLines: {
                        drawTicks: false,
                        display: true,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        zeroLineColor: "transparent",
                    },
                    ticks: {
                        padding: 10,
                        fontStyle: "500",
                    },
                },
            ],
        },
        legendCallback: function (chart) {
            var text = [];
            text.push('<ul class="' + chart.id + '-legend html-legend">');
            for (var i = 0; i < chart.data.datasets.length; i++) {
                text.push(
                    '<li><span style="background-color:' +
                        chart.data.datasets[i].legendColor +
                        '"></span>'
                );
                if (chart.data.datasets[i].label) {
                    text.push(chart.data.datasets[i].label);
                }
                text.push("</li>");
            }
            text.push("</ul>");
            return text.join("");
        },
    },
});

var myLegendContainer = document.getElementById("sdgChartLegend");

// Generate HTML legend for SDGs
myLegendContainer.innerHTML = sdgChart.generateLegend();

// Bind onClick event to all LI-tags of the legend
var legendItems = myLegendContainer.getElementsByTagName("li");
for (var i = 0; i < legendItems.length; i += 1) {
    legendItems[i].addEventListener("click", legendClickCallback, false);
}

// Example of active users chart related to SDG metrics tracking
$("#sdgUsersChart").sparkline(
    [85, 90, 92, 95, 100, 85, 87, 90, 102, 109, 110, 99, 110, 115],
    {
        type: "bar",
        height: "100",
        barWidth: 9,
        barSpacing: 10,
        barColor: "rgba(54, 163, 247,.3)",
    }
);
