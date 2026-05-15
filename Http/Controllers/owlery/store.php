<?php

use Core\Session;
use Http\Models\MessageModel;

$currentUserId = current_user()['user_id'] ?? null;
$receiverId = isset($_POST['receiver_id']) ? (int) $_POST['receiver_id'] : null;
$messageBody = trim($_POST['message_body'] ?? '');

if (!$currentUserId) {
    abort(403);
}

$redirectTo = '/owlery';

if ($receiverId) {
    $redirectTo .= '?user=' . $receiverId;
}

if (!$receiverId || $receiverId === $currentUserId) {
    Session::flash('owlery_error', 'Choose a valid recipient before sending.');
    redirect($redirectTo);
}

if ($messageBody === '') {
    Session::flash('owlery_error', 'Message cannot be empty.');
    redirect($redirectTo);
}

$messageModel = new MessageModel();
$recipient = $messageModel->findUserById($receiverId);

if (!$recipient) {
    Session::flash('owlery_error', 'Recipient not found.');
    redirect('/owlery');
}

$messageModel->sendMessage($currentUserId, $receiverId, $messageBody);
redirect($redirectTo);
