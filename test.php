<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <style>
        #chart_div {
            width: auto;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <!-- CONTAINER FOR CHART -->
    <div id="chart_div"></div>
    <script type="text/javascript" loading="lazy" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // load current chart package
        google.charts.load("current", {
            packages: ["corechart", "line"]
        });
        // set callback function when api loaded
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // create data object with default value
            var data = google.visualization.arrayToDataTable([
                ["Year", "CPU Usage"],
                [0, 0]
            ]);
            // create options object with titles, colors, etc.
            var options = {
                title: "Realtime ",
                hAxis: {
                    title: "Time"
                },
                vAxis: {
                    title: "Temp"
                }
            };
            // draw chart on load
            var chart = new google.visualization.LineChart(
                document.getElementById("chart_div")
            );
            chart.draw(data, options);
            // interval for adding new data every 250ms
            var index = 0;

            setInterval(function() {
                // instead of this random, you can make an ajax call for the current cpu usage or what ever data you want to display
                let random;
                $.ajax({
                    url: 'current.php',
                    async: false,
                    success: function(data) {
                        console.log(data);
                        random = parseInt(data);
                    }

                });
                console.log(random);
                data.addRow([index, random]);
                chart.draw(data, options);
                index++;
            }, 1500);
        }
    </script>
</body>

</html>