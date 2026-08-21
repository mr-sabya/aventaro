<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash; use Illuminate\Support\Facades\Password; use Illuminate\Support\Str;
class PasswordController extends Controller {
 public function request(){return view('backend.auth.forgot-password');}
 public function email(Request $request){$request->validate(['email'=>'required|email']);$status=Password::sendResetLink($request->only('email'));return $status===Password::RESET_LINK_SENT?back()->with('status',__($status)):back()->withErrors(['email'=>__($status)]);}
 public function reset(Request $request,string $token){return view('backend.auth.reset-password',['token'=>$token,'email'=>$request->email]);}
 public function update(Request $request){$data=$request->validate(['token'=>'required','email'=>'required|email','password'=>'required|confirmed|min:12']);$status=Password::reset($data,function($user,$password){$user->forceFill(['password'=>Hash::make($password),'remember_token'=>Str::random(60)])->save();});return $status===Password::PASSWORD_RESET?redirect()->route('admin.login')->with('status',__($status)):back()->withErrors(['email'=>__($status)]);}
}
