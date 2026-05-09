<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class InventoryController
{
    public function index()
    {
        $db = \Core\App::resolve(\Core\Database::class);

        if (!isset($_SESSION['student_id'])) {
            $_SESSION['student_id'] = 1;
        }

        $studentId = $_SESSION['student_id'];

        $items = $db->query("
    SELECT 
        Inventory.item_id,
        Inventory.quantity,
        DiagonAlleyShop.item_name,
        DiagonAlleyShop.item_price,
        DiagonAlleyShop.item_type
    FROM Inventory
    JOIN DiagonAlleyShop 
        ON Inventory.item_id = DiagonAlleyShop.item_id
    WHERE Inventory.student_id = :id
", [
            'id' => $studentId
        ])->get();
        return view('inventory.view.php', [
            'items' => $items ?? []
        ]);
    }
    public function remove()
    {
        $db = App::resolve('Core\Database');

        $studentId = $_SESSION['student_id'] ?? 1;
        $itemId = $_POST['item_id'] ?? null;

        if (!$itemId) {
            header("Location: /inventory");
            exit();
        }

        // check item
        $item = $db->query("
        SELECT * FROM Inventory
        WHERE student_id = :sid AND item_id = :iid
    ", [
            'sid' => $studentId,
            'iid' => $itemId
        ])->find();

        if (!$item) {
            header("Location: /inventory");
            exit();
        }

        // decrease quantity
        if ($item['quantity'] > 1) {

            $db->query("
            UPDATE Inventory
            SET quantity = quantity - 1
            WHERE student_id = :sid AND item_id = :iid
        ", [
                'sid' => $studentId,
                'iid' => $itemId
            ]);

        } else {

            // delete if 1
            $db->query("
            DELETE FROM Inventory
            WHERE student_id = :sid AND item_id = :iid
        ", [
                'sid' => $studentId,
                'iid' => $itemId
            ]);
        }

        header("Location: /inventory");
        exit();
    }
}