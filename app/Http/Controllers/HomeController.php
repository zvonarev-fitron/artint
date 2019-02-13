<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class HomeController extends Controller
{
    private $params = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }


    /**
     * Начальная страница
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->params['orders'] = Order::all();
//        dump($this->params);
        return view('welcome', ['params' => $this->params]);
    }
}
