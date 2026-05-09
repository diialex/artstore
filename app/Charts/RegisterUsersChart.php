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
            ->setTitle($data['title'])
            ->setSubtitle($data['subtitle'])
            ->addData($data['data'], 'Users')
            ->setXAxis($data['labelX']);
    }
}
