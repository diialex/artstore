<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Services\AddressService;
use App\Services\UsersService;
use Illuminate\Http\Request;

class ControlPanelController extends Controller
{
    public function __construct(){}
    public function index(){
        return view('controlPanel.dashboard');
    }
}