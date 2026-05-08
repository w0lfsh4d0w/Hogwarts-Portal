<?php

namespace Controllers;

class ShopController
{
    private function items()
    {
        return [
            ['id' => 1, 'name' => 'Holly Wand', 'category' => 'wand', 'price' => 100],
            ['id' => 2, 'name' => 'Dragon Heart Potion', 'category' => 'potion', 'price' => 50],
            ['id' => 3, 'name' => 'Ancient Spell Book', 'category' => 'book', 'price' => 200],
        ];
    }

    public function index()
    {
        return view('shop.view.php', [
            'items' => $this->items()
        ]);
    }

    public function buy()
    {
        $itemId = $_POST['item_id'];

        if (!isset($_SESSION['inventory'])) {
            $_SESSION['inventory'] = [];
        }

        if (!isset($_SESSION['inventory'][$itemId])) {
            $_SESSION['inventory'][$itemId] = 1;
        } else {
            $_SESSION['inventory'][$itemId]++;
        }

        header('Location: /shop');
        exit();
    }
}