<?php
namespace App\Services;

use App\Models\User;

class UserService{

    /**
     * Create user service.
     */
    public function store($name, $email, $phone_number, $password){
        return User::create([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password
        ]);
    }

    /**
     * Get users service.
     */
    public function all(){
        return User::get();
    }
}

?>
