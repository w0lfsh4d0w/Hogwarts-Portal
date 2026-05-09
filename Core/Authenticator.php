<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)->query("SELECT * FROM User WHERE email = :email", [
            ':email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password']) || hash_equals($user['password'], $password)) {
                $this->login([
                    'user_id' => $user['user_id'],
                    'user_name' => $user['user_name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ]);
                return true;
            }
        }
        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'user_id' => $user['user_id'] ?? null,
            'user_name' => $user['user_name'] ?? null,
            'email' => $user['email'],
            'role' => $user['role'] ?? null,
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
