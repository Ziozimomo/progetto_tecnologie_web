<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\EventsList;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->eventsList = new EventsList;
    }

    public function index() {

        $nearEvents=$this->eventsList->getNearEvents();
        return view('home')->with('nearEvents', $nearEvents);
    }

    public function AreaRiservata(){
        $user = auth()->user();
        //TODO creare la view dello user
        return view('User')->with('user',$user);
    }

}
