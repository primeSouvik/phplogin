<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="js/myscripts.js?random=<?php echo uniqid(); ?>"></script>
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
                ["time", "temp"],
                [0, 0]
            ]);
            // create options object with titles, colors, etc.
            var options = {

                legend: {
                    position: 'none'
                },
                chartArea: {
                    // leave room for y-axis labels
                    width: '80%',
                    height: '85%',
                },
                height: 240,
                hAxis: {
                    title: "Time"
                },
                curveType: 'function',
                vAxis: {
                    title: "Temp"
                },
                pointsVisible: false,
                displayAnnotations: true

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
            }, 1000);
        }
    </script>
    <script>

    </script>
</head>
<?php

?>

<body class="sb-nav-fixed" onload="startTime()">
    <nav class=" sb-topnav navbar navbar-expand navbar-dark bg-dark nav navbar-nav navbar-right">
        <a class="navbar-brand" href="#">Team Origin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="info.html">
                    Info
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.html">
                    Contact
                </a>
            </li>
        </ul>
        <a class="btn btn-outline-light btn-sm " href="logout" role="button">Logout</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a><a class="nav-link" href="tables">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php
                    echo $_SESSION['username'];
                    ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4" style="text-align: center;">Temprature Information</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Welcome to Dashboard -- Current Time: <span id="currentTime"></span></li>

                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Current Temp : <span id="autoCurrent"></span>°C</div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Average Temp : <span id="autoAvg"></span>°C</div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Minimum Temp : <span id="autoMin"></span>°C</div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Maximum Temp : <span id="autoMax"></span>°C</div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4" id="screen">
                                <div class="card-header"><i class="fas fa-chart-area mr-1"></i>All day temp.</div>
                                <canvas id="myChartA"></canvas>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4" id="myChartReal">
                                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Real time temp.</div>
                                <div id="chart_div"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-table mr-1"></i>DataTable Example</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>66</td>
                                            <td>2009/01/12</td>
                                            <td>$86,000</td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>22</td>
                                            <td>2012/03/29</td>
                                            <td>$433,060</td>
                                        </tr>
                                        <tr>
                                            <td>Airi Satou</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>33</td>
                                            <td>2008/11/28</td>
                                            <td>$162,700</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#autoCurrent").load('current.php')
            }, 500);
        });
        $(document).ready(function() {
            setInterval(function() {
                $("#autoAvg").load('avg.php')
            }, 500);
        });
        $(document).ready(function() {
            setInterval(function() {
                $("#autoMin").load('min.php')
            }, 500);
        });
        $(document).ready(function() {
            setInterval(function() {
                $("#autoMax").load('max.php')
            }, 500);
        });

        $(document).ready(function() {
            setInterval(function() {
                $("#myChart").load('js/myscripts.js')
            }, 200);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="assets/demo/chart-area-demo.js"></script> -->
    <!-- <script src="assets/demo/chart-bar-demo.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>