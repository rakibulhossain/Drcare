<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\VerifyUser;


use App\Admin;
use App\Mail\VerifyMail;
use App\Mail\forgot_passwordMail;
use Mail;
use Session;
use Image;

class AdminController extends Controller
{
    //
    public function admin_login(Request $request)
    {
        $email= $request->email;
        $password=$request->password;

        $user= Admin::where('email','=',$email)
                    ->where('password','=',$password)
                    ->first();

        if($user && $user->verified)
        {
            $request->session()->put('username',$user->username);
            $request->session()->put('password',$user->password);
            return view('admin.pages.index',['user' => $user]);

        }

        else if($user && !$user->verified)
        {
            return redirect()->back()->with('msg', "Sorry your email cannot be identified. Confirm The mail");
        }

        else
        {
            return redirect()->back()->with('msg',"The email or password you have entered is not correct");
        }


    }

    public function admin_logout(Request $request)
    {
        $request->session()->flush();
        return redirect::to('login');

    }

    public function store(Request $request)
    {
    	 $request->validate([

    	 	'username' => 'required',
    	 	'email' => 'required|email|unique:admins',
    	 	'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',

    	 ]);

    	 $username= $request->username;
    	 $email=$request->email;
    	 $password=$request->password;



         $obj= new Admin();
         $obj->username=$username;
         $obj->email=$email;
         $obj->password=$password;

         if($obj->save())
         {
            $verifyUser = VerifyUser::create([
            'admin_id' => $obj->id,
            'token' => str_random(40)
            ]);

            Mail::to($obj->email)->send(new VerifyMail($obj));

            return redirect('/login')->with('msg', 'We sent you an activation code. Check your email and click on the link to verify.');
         }
    }

    public function verifyUser($token)
    {
        $verifyUser = Verifyuser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = Admin::where('id',$verifyUser->admin_id)->first();
            if(!$user->verified) {
                $user->verified = 1;
                $user->save();
                $msg = "Your e-mail is verified. You can now login.";
            }else{
                $msg = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('msg', "Sorry your email cannot be identified.");
        }

        return redirect('/login')->with('msg', $msg);
    }

    public function forgot_pass(Request $request)
    {
        $email=$request->email;


        $user=Admin::where('email','=',$email)->first();

        if(!$user)
        {
            return redirect()->back()->with('msg', "Sorry your email cannot be identified.");
        }
        else if(!$user->verified)
        {
            return redirect('/login')->with('msg', "Sorry, you did not confirmed your mail.  your email cannot be identified. ");
        }
        else
        {
            Mail::to($user->email)->send(new forgot_passwordMail($user));
            return redirect('/login')->with('msg', "We sent you an password reset link. Check your email and click on the link to reset.");
        }
    }

    public function password_reset($id)
    {

        $user = Admin::where('id','=',$id)->first();
        $user_id=$id;

        return view('admin.pages.passwordreset',['id' => $id]);

    }

    public function restore(Request $request)
    {
        $user=Admin::where('id','=',$request->id)->first();



        $user->password=$request->password;

        $user->save();


        return redirect('/login')->with('msg', 'Passward has reset, You can login now');

    }


    public function update(Request $request,Admin $user)
    {


        $image = $request->file('image');
        $filename= time().'.'.$image->getClientOriginalExtension();
     
   
        $destinationPath = public_path('/user_image');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$filename);

        $obj=Admin::where('id','=',$user->id)->first();

        $obj->profile_image=$filename;
        $obj->first_name=$request->first_name;
        $obj->last_name=$request->last_name;
        $obj->date_of_birth=$request->date_of_birth;
        $obj->gender=$request->gender;
        $obj->state=$request->state;
        $obj->country=$request->country;
        $obj->pincode=$request->pincode;
        $obj->number=$request->number;
        $obj->address=$request->address;
        $obj->save();

        return view('admin.pages.profile',['user' => $obj]);

    }

    public function index(Admin $user)
    {
        return view('admin.pages.index',['user' => $user ]);
    }


    public function profileedt(Admin $user)
    {
        return view('admin.pages.edit_profile',['user' => $user]);

    }

    public function profile(Admin $user)
    {
        return view('admin.pages.profile',['user' => $user]);
    }

}
