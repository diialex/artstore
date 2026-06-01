<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\MetricsService;

class RevenueByCategoryChart
{
    protected $chart;
    protected $service;

    public function __construct(LarapexChart $chart, MetricsService $service)
    {
        $this->chart = $chart;
        $this->service = $service;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $data = $this->service->getRevenueByCategory();

        return $this->chart->pieChart()
            ->setHeight(320)
            ->setColors(['#671646', '#3B7A41', '#A4CFAB', '#3B2B30', '#cf8fb5', '#99FFA3'])
            ->addData($data['data'])
            ->setLabels($data['labels']);
    }
}
