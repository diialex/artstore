<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Services\UsersService;

class RegisterUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $service = new UsersService();
        $data = $service->getDataChartUserRegister();
        return $this->chart->barChart()
            ->setHeight(320)
            ->setColors(['#671646'])
            ->addData($data['data'], __('messages.user'))
            ->setXAxis($data['labelX']);
    }
}
