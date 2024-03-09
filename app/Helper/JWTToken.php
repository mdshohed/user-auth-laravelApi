<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
// use Laravel\Prompts\Key;

class JWTToken{
  public static function CreateToken($userEmail, $userID):string{
    // $key = env('JWT_KEY');
    $key = "12345";
    // return $key; 
    $payload=[
      'iss'=>'laravel-token',
      'iat'=>time(),
      'exp'=>time()*60*60,
      'userEmail'=>$userEmail,
      'userID'=>$userID
    ];
    return JWT::encode($payload, $key, 'HS256');
  }

  public static function CreateTokenForSetPassword($userEmail):string{
    // $key = env('JWT_KEY');
    $key = "12345";
    $payload=[
      'iss'=>'laravel-token',
      'iat'=>time(),
      'exp'=>time()*60*20,
      'userEmail'=>$userEmail,
      'userID'=>'0',
    ];
    return JWT::encode($payload, $key, 'HS256');
  }

  public static function VerifyToken($token):string|object{
    try{
      // $key = env('JWT_KEY');
      if($token==null){
        return 'unauthorized';
      }
      else{
        $key = "12345";
        $decode = JWT::decode($token, new Key($key, 'HS256'));
        // print_r($decoded);
        return $decode;
      }
    }
    catch(Exception $e){
      return 'unauthorized';
    }
  }
}