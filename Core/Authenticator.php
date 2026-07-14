<?php

namespace Core;

use Http\Models\UserModel;

class Authenticator
{
    public function attempt($email, $password)
    {
        $userModel = new UserModel();
        $user = $userModel->findUserWithStudent($email);

        if ($user) {
            if (password_verify($password, $user['password']) ) {
                $this->login($user);
                return true;
            }
        }
        return false;
    }

  public function login($user)
{
    $token = JwtService::generate([
        'user_id'    => $user['user_id'],
        'student_id' => $user['student_id'],
        'email'      => $user['email'],
        'role'       => $user['role'],
        'house_id'   => $user['house_id']
    ]);

    JwtService::setTokenCookie($token);
}

   public function logout()
{
    setcookie('token', '', time() - 3600, '/');
}
}
