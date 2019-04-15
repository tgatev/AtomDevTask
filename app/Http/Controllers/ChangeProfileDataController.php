<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChangeProfileDataController extends Controller
{
    use RedirectsUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('change_profile_data' );
    }

    public function change( Request $request ){
        $this->validator($request->all())->validate();
        $user = User::find(Auth::user()->id);


        $user->first_name = $request->input('name');
        $user->last_name = $request->input('family');
        $user->email = $request->input('email');
        $user->save();
        Auth::setUser($user);
        return view('change_profile_data' , [array("changed" => 1 )] );
    }

    protected function validator($data){
        $rules = User::getValidationRules( Auth::user()->id ) ;
        unset($rules["password"]);
        return Validator::make($data, $rules );
    }
}
