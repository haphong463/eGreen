<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- iconscount link css -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">


    <title>Admin Dashboard Panel</title>
</head>

<body>
    <?php
    include('part/menu-left.php');
    ?>

    <section class="dashboard">

        <?php
        include('part/header.php');
        ?>
            <br><br><br>

            <div class="row">
                <div class="col-xl-6 xl-100">
                    <div class="card btn-months">
                        <div class="card-header">
                            <h5 id="text-date"></h5>
                            <div class="dashboard-btn-groups">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <input type="text" style="font-size:0.9rem" value="28" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Enter days..." id="daysInput">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="myfirstchart" style="height: 250px;"></div>
                            <div id="chartLegend"></div> <!-- Vùng chứa chú thích tùy chỉnh cho myfirstchart -->
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 xl-100">
                    <div class="card btn-months">
                        <div class="card-header">
                            <h5 id="text-date-year"></h5>
                        </div>
                        <div class="card-body">
                            <div id="yearChart" style="height: 250px;"></div>
                            <div id="yearChartLegend"></div> <!-- Vùng chứa chú thích tùy chỉnh cho yearChart -->
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 xl-100">
                    <div class="card btn-months">
                        <div class="card-header">
                            <h5 id="text-date-month"></h5>
                            <div class="dashboard-btn-groups">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <input type="text" style="font-size:0.9rem" maxlength="4" value="2023" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Enter year..." id="yearInput">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="monthChart" style="height: 250px;"></div>
                            <div id="monthChartLegend"></div> <!-- Vùng chứa chú thích tùy chỉnh cho monthChart -->
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Container-fluid Ends-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        $(document).ready(function() {
            var char = new Morris.Area({
                element: 'myfirstchart',
                xkey: 'date',
                ykeys: ['order', 'revenue', 'quantity'],
                labels: ['Orders', 'Revenue', 'Sold out'],
                xLabels: 'date',
                hideHover: 'auto',
                resize: true,
                lineColors: ['#6b5ca5', '#66ccff', '#ff4e00'],
                lineWidth: 2,
                pointSize: 4,
                smooth: true
            });

            var yearChart = new Morris.Area({
                element: 'yearChart',
                xkey: 'year',
                ykeys: ['order', 'revenue', 'quantity'],
                labels: ['Orders', 'Revenue', 'Sold out'],
                xLabels: 'year',
                xLabelFormat: function(date) {
                    return moment(date, 'YYYY').format('YYYY');
                },
                xLabelMargin: 10,
                hideHover: 'auto',
                resize: true,
                lineColors: ['#6b5ca5', '#66ccff', '#ff4e00'],
                lineWidth: 2,
                pointSize: 4,
                smooth: true
            });
            var monthChart = new Morris.Area({
                element: 'monthChart',
                xkey: 'date',
                ykeys: ['order', 'revenue', 'quantity'],
                labels: ['Orders', 'Revenue', 'Sold out'],
                xLabelFormat: function(date) {
                    return moment(date, 'MM/YYYY').format('MM/YYYY');
                },
                hideHover: 'auto',
                resize: true,
                lineColors: ['#6b5ca5', '#66ccff', '#ff4e00'],
                lineWidth: 2,
                pointSize: 4,
                smooth: true
            });

            $('#yearInput').on('input', function() {
                var year = parseInt($(this).val());
                if (!isNaN(year) && year > 0) {
                    var text = 'Statistical by year: ' + year;
                    $.ajax({
                        url: "revenue.php",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            year: year
                        },
                        success: function(data) {
                            yearChart.setData(data);
                            $('#text-date-month').text(text);
                        }
                    });
                }
            });
            $('#daysInput').on('input', function() {
                var days = parseInt($(this).val());
                if (!isNaN(days) && days > 0) {
                    var text = 'Last ' + days + ' days';
                    $.ajax({
                        url: "revenue.php",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            days: days
                        },
                        success: function(data) {
                            char.setData(data);
                            $('#text-date').text(text);
                        }
                    });
                }
            });


            function getMonthChartData(year) {
                var text = 'Statistical by month of ' + year;
                $.ajax({
                    url: "revenue.php",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        year: year
                    },
                    success: function(data) {
                        monthChart.setData(data);
                        $('#text-date-month').text(text);
                    }
                });
            }

            function getYearChartData() {
                $.ajax({
                    url: "revenue.php",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        yearData: true
                    },
                    success: function(data) {
                        yearChart.setData(data);
                        $('#text-date-year').text('Statistical by year');
                    }
                });
            }

            function getDefaultChartData() {
                var text = 'Last 28 days';
                $.ajax({
                    url: "revenue.php",
                    method: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });
            }
            $('#yearInput').on('input', function() {
                var selectedYear = parseInt($(this).val());
                if (!isNaN(selectedYear) && selectedYear > 0) {
                    getMonthChartData(selectedYear);
                }
            });
            getMonthChartData(2023); // Tải dữ liệu theo năm mặc định
            getYearChartData(); // Lấy dữ liệu theo năm mặc định
            getDefaultChartData(); // Lấy dữ liệu theo ngày mặc định

            // Tạo chú thích tùy chỉnh cho myfirstchart
            var legendItems = char.options.labels.map(function(label, index) {
                var color = char.options.lineColors[index];
                return '<span style="margin-right: 10px;color: ' + color + ';"><i class="fas fa-circle" style="color: ' + color + ';"></i> ' + label + '</span>';
            });
            $('#chartLegend').html(legendItems.join(''));

            // Tạo chú thích tùy chỉnh cho yearChart
            var yearChartLegendItems = yearChart.options.labels.map(function(label, index) {
                var color = yearChart.options.lineColors[index];
                return '<span style="margin-right: 10px;color: ' + color + ';"><i class="fas fa-circle" style="color: ' + color + ';"></i> ' + label + '</span>';
            });
            $('#yearChartLegend').html(yearChartLegendItems.join(''));
            var monthChartLegendItems = monthChart.options.labels.map(function(label, index) {
                var color = monthChart.options.lineColors[index];
                return '<span style="margin-right: 10px;color: ' + color + ';"><i class="fas fa-circle" style="color: ' + color + ';"></i> ' + label + '</span>';
            });
            $('#monthChartLegend').html(monthChartLegendItems.join(''));


        });
    </script>
    <script src="script.js"></script>
</body>

</html>