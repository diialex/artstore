<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use DateTime;

class UsersService
{
    public function getAll(): Collection
    {
        return User::all();
    }
    
    public function get(string $id) : User
    {
        $user = User::find($id);
        if(!$user){
            throw new Exception("Usuario no existe");
        }
        return $user;
    }

    public function store($user){
        $user->saveOrFail();
    }

    public function getUserByUsername(string $username) : User
    {
        return User::where('username', $username)->first();
    }

    public function update($user, $role){
        $user->save();

        $user->roles()->sync($role);
    }

    public function delete($user){
        $user->delete();
    }

    public function login($request){
        if(!$request->userCredential){
            return null;
        }
        if (filter_var($request->userCredential, FILTER_VALIDATE_EMAIL)){
            return User::where('email', $request->userCredential)->first();
        }else{
            return $this->getUserByUsername($request->userCredential);
        }
    }

    public function getAllRolUser(){
        return User::whereHas('roles', function($query) {
            $query->where('name', 'user');
                })->get();
    }

    public function getDataChartUserRegister(){
        $label_months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $date = new DateTime();
        $users = $this->getAllRolUser();

        $currentMonth = (int)$date->format('n');
        $currentYear = (int)$date->format('Y');

        $months = array_fill(0,$currentMonth,0);

        $labelMonths = array_slice($label_months, 0, $currentMonth);
        
        foreach($users as $user){
            if($user->created_at->year == $currentYear){
                $month=(int)$user->created_at->month-1;
                $months[$month]+=1;
            }
            
        }

        return ["title" => 'Users Register', 
                "subtitle"=>'Users register this year',
                "data" => $months,
                "labelX"=> $labelMonths];
    }

    public function getDataChartSalesPerUsers(){
        $users=$this->getAllRolUser();
        $top = array_fill(0, 10, 0);
        $top_label = array_fill(0,10, "");
        foreach($users as $user){
            if($user->orders !=null){
                $ordersCount = count($user->orders);
                for($i = 0; $i < count($top); $i++){
                    if($top[$i]<$ordersCount){
                        $top[$i] = $ordersCount;
                        $top_label[$i] = $user->username;
                        break;
                    }
                }
            }
            
        }

        return ["title" => 'Top 10 orders per user', 
                "subtitle"=>'User orders',
                "data" => $top,
                "labelX"=> $top_label];
    }
}