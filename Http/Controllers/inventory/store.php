<?php

use Core\Session;
use Http\Models\InventoryModel;

$user = \Core\JwtService::verify(\Core\JwtService::getTokenFromCookie());
$studentId = $user['student_id'] ?? null;
$itemId = $_POST['item_id'] ?? null;

if (!$studentId || !$itemId) {
    redirect('/inventory');
}

$inventoryModel = new InventoryModel();
$inventoryItem = $inventoryModel->findItem($studentId, $itemId);

if (!$inventoryItem) {
    redirect('/inventory');
}

if ((int) $inventoryItem['quantity'] > 1) {
    $inventoryModel->decrementItem($studentId, $itemId);
} else {
    $inventoryModel->removeItem($studentId, $itemId);
}

Session::flash('success', 'Item removed from your inventory.');
redirect('/inventory');
