<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2015/9/23
 * Time: 0:26
 */

class AccountModel{
    //set correct username and password
    private static $Username = "Admin";
    private static $Password = "Password";

    //check if parameter are same as correct username and password
    public function check($name,$pass){

        if($name == self::$Username && $pass == self::$Password){
            return true;
        }else{
            return false;
        }
    }
}