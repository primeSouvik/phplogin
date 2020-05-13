<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
    <canvas id="myChart" height="30" width="50"></canvas>
    <script>
        const xlabel = [];
        const ylabel = [];
        chartIt();
        async function chartIt() {
            await getData();
            var ctx = document.getElementById('myChart').getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: xlabel,
                    datasets: [{
                        label: 'temprature',
                        data: ylabel,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
        async function getData() {
            const response = await fetch('allDay.csv');
            const data = await response.text();
            console.log(data);

            const table = data.split('\n');

            table.forEach(row => {
                const columns = row.split(',');
                const time = columns[0];
                xlabel.push(time);
                const temp = columns[1];
                ylabel.push(temp);
                console.log(time, temp);
            });
        }
    </script>

</body>

</html>