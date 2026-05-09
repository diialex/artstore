<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\UsersService;


class OrdersPerUsers
{
    protected $chart;
    protected $service;

    public function __construct(LarapexChart $chart, UsersService $service)
    {
        $this->chart = $chart;
        $this->service = $service;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = $this->service->getDataChartSalesPerUsers();
        return $this->chart->barChart()
            ->setTitle($data['title'])
            ->setSubtitle($data['subtitle'])
            ->addData($data['data'], 'Users')
            ->setXAxis($data['labelX']);
    }
}
