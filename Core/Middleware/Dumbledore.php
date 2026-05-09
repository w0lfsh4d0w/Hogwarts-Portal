<?php

namespace Core\Middleware;

class Dumbledore
{
    public function handle()
    {
        if (!($_SESSION['user'] ?? false)) {
            header('Location: /');
            exit();
        }

        if (($_SESSION['user']['role'] ?? null) !== 'Dumbledore') {
            \abort(403);
        }
    }
}
