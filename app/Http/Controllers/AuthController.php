<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    
 
    public function index(){

     return view('Auth.login');
     
   }



    public function login(Request $request)
    {
   
    try{

    $user = User::where('name', $request->usuario)->first();              
             
        
      if (!$user) {
        return Redirect::back()->with('message', 'Login inválido');
   }

   if (! Hash::check($request->senha, $user->password)) {
    return Redirect::back()->with('message', 'Login inválido');
}

  $auth = Auth::login($user);


   return Redirect::to('/dashboard');

}catch (Throwable $e) {
  report($e);

  return Redirect::back()->with('error', 'Ocorreu um erro ao tentar fazer login.Por favor,Tente Novamente');
}
  
    }


    public function logout(){     
       
      $user = Auth::user();

    if(!$user){
    
      return Redirect::to('/login');
    
  }
      Auth::logout();
      return Redirect::to('/login');
  }


}
