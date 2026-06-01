<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\MetricsService;

class RevenuePerMonthChart
{
    protected $chart;
    protected $service;

    public function __construct(LarapexChart $chart, MetricsService $service)
    {
        $this->chart = $chart;
        $this->service = $service;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $data = $this->service->getRevenuePerMonth();

        return $this->chart->areaChart()
            ->setHeight(320)
            ->setColors(['#671646'])
            ->setStroke(3, ['#671646'], 'smooth')
            ->setDataLabels(false)
            ->addData($data['data'], __('messages.chart_revenue'))
            ->setXAxis($data['labelX']);
    }
}
