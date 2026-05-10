<?php

namespace Core;
use Http\Models\UserModel ;
class Authenticator
{
    public function attempt($email, $password)
    {
        $userModel = new UserModel();
        $user = $userModel->FindUser($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login($user);
                return true;
            }
        }
        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'user_id'    => $user['user_id'],
            'student_id' => $user['student_id'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'house_id'   => $user['house_id']
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
