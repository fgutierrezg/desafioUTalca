<?php
namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class ExternalUser  implements Authenticatable, JWTSubject
{

    public $userData; // Datos del usuario desde la API externa

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }
    
    public function getAuthIdentifierName(){
        return "email";
    }
    public function getAuthIdentifier(){
        return $this->userData['email'];
    }
    public function getAuthPassword(){
        return $this->userData['password'];

    }
    public function getRememberToken(){

        return "";
    }
    public function setRememberToken($value){

    }
    public function getRememberTokenName(){
        return "";
        
    }

    public function getJWTIdentifier()
    {
        return $this->userData['email'];
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
