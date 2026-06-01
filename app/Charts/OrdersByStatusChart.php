<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\MetricsService;

class OrdersByStatusChart
{
    protected $chart;
    protected $service;

    public function __construct(LarapexChart $chart, MetricsService $service)
    {
        $this->chart = $chart;
        $this->service = $service;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $data = $this->service->getOrdersByStatus();

        return $this->chart->donutChart()
            ->setHeight(320)
            ->setColors(['#3B7A41', '#671646', '#cf8fb5', '#3B2B30'])
            ->addData($data['data'])
            ->setLabels($data['labels']);
    }
}
