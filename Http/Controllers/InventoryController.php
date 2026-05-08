<?php

namespace Controllers;

class InventoryController
{
    public function index()
    {
        $inventory = $_SESSION['inventory'] ?? [];

        return view('inventory.view.php', [
            'inventory' => $inventory
        ]);
    }
}