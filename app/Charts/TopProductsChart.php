<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\MetricsService;

class TopProductsChart
{
    protected $chart;
    protected $service;

    public function __construct(LarapexChart $chart, MetricsService $service)
    {
        $this->chart = $chart;
        $this->service = $service;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        $data = $this->service->getTopSellingProducts();

        return $this->chart->horizontalBarChart()
            ->setHeight(320)
            ->setColors(['#3B7A41'])
            ->addData($data['data'], __('messages.chart_units'))
            ->setXAxis($data['labelX']);
    }
}
