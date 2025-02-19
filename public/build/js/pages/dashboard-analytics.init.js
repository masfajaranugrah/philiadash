
// get colors array from the string
function getChartColorsArray(chartId) {
    const chartElement = document.getElementById(chartId);
    if (chartElement) {
        const colors = chartElement.dataset.colors;
        if (colors) {
            const parsedColors = JSON.parse(colors);
            const mappedColors = parsedColors.map((value) => {
                const newValue = value.replace(/\s/g, "");
                if (!newValue.includes(",")) {
                    const color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    return color.replace(" ", "") || newValue;
                } else {
                    const val = value.split(",");
                    if (val.length === 2) {
                        const rgbaColor = `rgba(${getComputedStyle(document.documentElement).getPropertyValue(val[0])}, ${val[1]})`;
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
            return mappedColors;
        } else {
            console.warn(`data-colors attribute not found on: ${chartId}`);
        }
    }
}

var chartColumnDistributedChart = "";
var realizedRateChart = "";
var balanceOverviewChart = "";
var usersActivityChart = "";
var chartHeatMapShadesChart = "";
var chartSemiRadialbarChart = "";
 
async function fetchVisitorData() {
    try {
        const apiUrl = window.Laravel.apiUrl; // Ambil nilai dari Blade
        const response = await fetch(`${apiUrl}/visitor/device-counts`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Process the data for the chart
        const devices = data.map(item => item.device);
        const counts = data.map(item => item.count);

        // Use this data in your chart
        loadCharts(devices, counts);
    } catch (error) {
        console.error('Error fetching visitor data:', error);
    }
}

function loadCharts(devices, counts) {
    var chartColumnDistributedColors = getChartColorsArray("performance_overview");

    if (chartColumnDistributedColors) {
        var options = {
            series: [{
                name: 'Websites',
                type: 'column',
                data: counts,
            }],
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                    borderRadiusOnAllStackedSeries: true,
                },
            },
            colors: chartColumnDistributedColors,
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                categories: devices,
            },
        };

        if (chartColumnDistributedChart != "")
            chartColumnDistributedChart.destroy();
        
        chartColumnDistributedChart = new ApexCharts(document.querySelector("#performance_overview"), options);
        chartColumnDistributedChart.render();
    }
}

// Call the function to load the chart with data
fetchVisitorData();

window.addEventListener("resize", function () {
    setTimeout(() => {
        loadCharts();
    }, 250);
});
loadCharts();

 
 

// sortble-dropdown
var sorttableDropdown = document.querySelectorAll('.sortble-dropdown');
if (sorttableDropdown) {
    sorttableDropdown.forEach(function (elem) {
        elem.querySelectorAll('.dropdown-menu .dropdown-item').forEach(function (item) {
            item.addEventListener('click', function () {
                var getHtml = item.innerHTML;
                elem.querySelector('.dropdown-title').innerHTML = getHtml;
            });
        });
    });
}