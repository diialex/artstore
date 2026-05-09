<?php

namespace App\Http\Controllers;

use App\Charts\OrdersPerUsers;
use App\Charts\RegisterUsersChart;
use App\Models\Address;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Services\AddressService;
use App\Services\UsersService;
use Illuminate\Http\Request;

class ControlPanelController extends Controller
{
    public function __construct(){}
    public function index(RegisterUsersChart $registerUsersChart, OrdersPerUsers $ordersPerUsers){
        return view('controlPanel.dashboard', ['usersRegisterThisYear' => $registerUsersChart->build(),
                                                'ordersPerUser' => $ordersPerUsers->build()]);
    }
}