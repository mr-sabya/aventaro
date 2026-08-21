<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash; use Illuminate\Validation\Rule;
class AccountController extends Controller {
 public function edit(Request $request){return view('backend.auth.profile',['user'=>$request->user()]);}
 public function update(Request $request){$user=$request->user();$data=$request->validate(['name'=>'required|string|max:120','email'=>['required','email','max:255',Rule::unique('users')->ignore($user->id)],'current_password'=>'nullable|required_with:password|current_password','password'=>'nullable|confirmed|min:12']);if(!empty($data['password']))$data['password']=Hash::make($data['password']);unset($data['current_password']);$user->forceFill($data)->save();return back()->with('success','Profile updated.');}
}
