<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private static $secretKey = 'hogwarts-secret-key-2026-very-long-and-secure';
    private static $algorithm = 'HS256';
    public static function generate($payload)
    {
        $payload['exp'] = time() + (60 * 60 * 24);
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function verify($token)
    {
        try {
            return (array) JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getTokenFromCookie()
    {
        return $_COOKIE['token'] ?? null;
    }
    public static function setTokenCookie($token)
{
    setcookie('token', $token, [
        'expires'  => time() + (60 * 60 * 24),
        'httponly' => true,
        'path'     => '/'
    ]);
}
}
