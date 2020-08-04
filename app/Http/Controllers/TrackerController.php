<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tracker;


class TrackerController extends Controller
{
    public function save (){

    	//number of user connected or viewed
    Tracker::firstOrCreate([
        'ip'   => $_SERVER['REMOTE_ADDR']],
        ['ip'   => $_SERVER['REMOTE_ADDR'],
        'current_date' => date('Y-m-d')])->save();

    return view('welcome');

    } 
}
