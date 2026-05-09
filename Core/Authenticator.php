<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)->query("SELECT * FROM users WHERE email = :email", [
            ':email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'email' => $user['email']
                ]);
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
