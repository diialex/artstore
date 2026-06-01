<?php

namespace App\Http\Controllers;

use App\Charts\RegisterUsersChart;
use App\Charts\RevenueByCategoryChart;
use App\Charts\RevenuePerMonthChart;
use App\Charts\TopProductsChart;

class ControlPanelController extends Controller
{
    public function __construct() {}

    public function index(
        RegisterUsersChart $registerUsersChart,
        RevenuePerMonthChart $revenuePerMonthChart,
        TopProductsChart $topProductsChart,
        RevenueByCategoryChart $revenueByCategoryChart
    ) {
        return view('controlPanel.dashboard', [
            'usersRegisterThisYear' => $registerUsersChart->build(),
            'revenuePerMonth'       => $revenuePerMonthChart->build(),
            'topProducts'           => $topProductsChart->build(),
            'revenueByCategory'     => $revenueByCategoryChart->build(),
        ]);
    }
}
