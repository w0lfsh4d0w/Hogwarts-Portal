<?php

namespace Http\Controllers;

use Core\App;

class ShopController
{
    public function index()
    {
        $db = App::resolve('Core\Database');

        $items = $db->query("
            SELECT * FROM DiagonAlleyShop
        ")->get();

        return view('shop.view.php', [
            'items' => $items
        ]);
    }

    public function buy()
    {
        $db = App::resolve('Core\Database');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /shop");
            exit();
        }

        $studentId = $_SESSION['student_id'] ?? 1;
        $itemId = $_POST['item_id'] ?? null;

        if (!$itemId) {
            header("Location: /shop");
            exit();
        }

        $item = $db->query("
        SELECT * FROM DiagonAlleyShop
        WHERE item_id = :id
    ", ['id' => $itemId])->find();

        $student = $db->query("
        SELECT * FROM Student
        WHERE student_id = :id
    ", ['id' => $studentId])->find();

        if (!$item || !$student) {
            header("Location: /shop");
            exit();
        }

        if ($student['balance'] < $item['item_price']) {
            $_SESSION['error'] = "Not enough balance!";
            header("Location: /shop");
            exit();
        }

        $db->query("
        UPDATE Student
        SET balance = balance - :price
        WHERE student_id = :id
    ", [
            'price' => $item['item_price'],
            'id' => $studentId
        ]);

        $inventory = $db->query("
        SELECT * FROM Inventory
        WHERE student_id = :sid AND item_id = :iid
    ", [
            'sid' => $studentId,
            'iid' => $itemId
        ])->find();

        if ($inventory) {
            $db->query("
            UPDATE Inventory
            SET quantity = quantity + 1
            WHERE student_id = :sid AND item_id = :iid
        ", [
                'sid' => $studentId,
                'iid' => $itemId
            ]);
        } else {
            $db->query("
            INSERT INTO Inventory (student_id, item_id, quantity)
            VALUES (:sid, :iid, 1)
        ", [
                'sid' => $studentId,
                'iid' => $itemId
            ]);
        }

        header("Location: /inventory");
        exit();
    }
}