<?php
require_once '../carbon/autoload.php';
require_once '../db/dbhelper.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

if (isset($_POST['days'])) {
    $days = $_POST['days'];
} else {
    $days = 28; // Số ngày mặc định
}

$subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays($days)->toDateString();
$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

$sql = "SELECT * FROM statistical WHERE date BETWEEN '$subdays' AND '$now' ORDER BY date ASC";
$date = executeResult($sql);

$chart_data = [];
foreach ($date as $d) {
    $chart_data[] = array(
        'date' => $d['date'],
        'order' => $d['orders'],
        'revenue' => $d['revenue'],
        'quantity' => $d['quantity']
    );
}

if (isset($_POST['yearData'])) {
    $yearData = getYearData();
    echo json_encode($yearData);
} elseif (isset($_POST['year'])) {
    $year = $_POST['year'];
    $monthData = getMonthData($year);
    echo json_encode($monthData);
} else {
    echo json_encode($chart_data);
}

function getYearData()
{
    $sql = "SELECT YEAR(date) AS year, SUM(orders) AS `order`, SUM(revenue) AS revenue, SUM(quantity) AS quantity FROM statistical GROUP BY YEAR(date) ORDER BY YEAR(date) ASC";
    $result = executeResult($sql);

    $year_data = [];
    foreach ($result as $r) {
        $year_data[] = array(
            'year' => $r['year'],
            'order' => $r['order'],
            'revenue' => $r['revenue'],
            'quantity' => $r['quantity']
        );
    }

    return $year_data;
}

function getMonthData($year)
{
    $sql = "SELECT MONTH(date) AS `month`, SUM(orders) AS `order`, SUM(revenue) AS revenue, SUM(quantity) AS quantity FROM statistical WHERE YEAR(date) = $year GROUP BY MONTH(date) ORDER BY MONTH(date) ASC";
    $result = executeResult($sql);

    $month_data = [];
    for ($month = 1; $month <= 12; $month++) {
        $month_found = false;
        foreach ($result as $r) {
            if ($r['month'] == $month) {
                $month_data[] = array(
                    'month' => $month,
                    'order' => $r['order'],
                    'revenue' => $r['revenue'],
                    'quantity' => $r['quantity'],
                    'date' => date('Y-m', strtotime($year . '-' . $month . '-01'))
                );
                $month_found = true;
                break;
            }
        }
        if (!$month_found) {
            $month_data[] = array(
                'month' => $month,
                'order' => 0,
                'revenue' => 0,
                'quantity' => 0,
                'date' => date('Y-m', strtotime($year . '-' . $month . '-01'))
            );
        }
    }

    return $month_data;
}
