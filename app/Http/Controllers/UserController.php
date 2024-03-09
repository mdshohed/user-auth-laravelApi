<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $req){
        try{
            User::create([
                'firstName' => $req->input('firstName'),
                'lastName' => $req->input('lastName'),
                'email' => $req->input('email'),
                'mobile' => $req->input('mobile'),
                'password' => $req->input('password'),
                // 'otp' => $req->input('otp'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 200);
        }
    }

    function UserLogin(Request $req){
        // $key = '12345';
        // return $key;
        $res = User::where('email','=',$req->input('email'))
            ->where('password','=',$req->input('password'))
            ->select('id')->first(); 
        // $value = env("JWT_KEY");
        // return $value;
        if( $res!==null ){
            $token = JWTToken::CreateToken($req->input('email'), $res->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login successful',
                'authorization'=> [
                    'token' => $token, 
                    'type' => 'bearer'
                ]
            ],200)->cookie('token', $token, 60*24*30);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ],401);
        }
    }

    function SendOTPCode(Request $request){
        $email = $request->input('email');
        $otp = rand(10000, 99999);
        $count = User::where('email','=',$email)->count(); 
        // return $count;
        if( $count==1){
            //OTP email address
            Mail::to($email)->send(new OTPMail($otp));
            //OTP Code Table Insert
            User::where('email', '=', $email)->update(['otp'=>$otp]);
            return response()->json([
                'status' => 'success',
                'message' => '5 digit otp code has send to your email',
                // 'token' => $token
            ],200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ],401);
        }
    }

    function VerifyOTP(Request $req){
        $email = $req->input('email');
        $otp = $req->input('otp');
        $count = User::where('email', '=', $email)
                ->where('otp', '=', $otp)->count(); 
        if($count==1){
            // Database OTP update 
            User::where('email', '=', $email)->update(['otp'=>'0']);

            // pass reset token issue 
            $token = JWTToken::CreateTokenForSetPassword($req->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successful',
                'token' => $token
            ],200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Could not Found!'
            ],200);
        }
    }

    function ResetPassword(Request $req){
        try{
            $email = $req->header('email');
            $password = $req->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'something went wrong',
            ],200);
        }
    }

    function UserLogout(){
        return redirect('/login')->cookie('token', '', -1); 
    }
    
    function UserProfile(Request $req){
        $email = $req->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful', 
            'data' => $user
        ], 200);
    }
    function UpdateProfile(Request $req){
        $email = $req->header('email');
        $firstName = $req->input('firstName'); 
        $lastName = $req->input('lastName'); 
        $mobile = $req->input('mobile'); 
        $password = $req->input('password'); 
        $user=User::where('email','=',$email)
                ->update([
                    'firstName' => $firstName, 
                    'lastName' => $lastName, 
                    'mobile' => $mobile,
                    'password' => $password
                ]);
        if($user==1){
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful', 
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized', 
            ], 401);
        }
        
    }
}
