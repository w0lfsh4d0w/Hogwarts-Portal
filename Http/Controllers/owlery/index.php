<?php

use Core\Session;
use Http\Models\MessageModel;

$currentUser = current_user();
$currentUserId = $currentUser['user_id'] ?? null;

if (!$currentUserId) {
    abort(403);
}

$search = trim($_GET['q'] ?? '');
$isNewConversation = ($_GET['new'] ?? '') === '1';
$selectedUserId = isset($_GET['user']) ? (int) $_GET['user'] : null;

$messageModel = new MessageModel();

$activeUser = null;
$messages = [];

if ($selectedUserId && $selectedUserId !== $currentUserId) {
    $activeUser = $messageModel->findUserById($selectedUserId);

    if ($activeUser) {
        $messageModel->markConversationRead($currentUserId, $selectedUserId);
        $messages = $messageModel->getConversation($currentUserId, $selectedUserId);
    }
}

$includeAllUsers = $isNewConversation;

$users = $messageModel->listUsersForMessaging(
    $currentUserId,
    null,
    $includeAllUsers
);

$roleGroups = [
    'Student' => ['label' => 'Students', 'recent' => [], 'others' => []],
    'Professor' => ['label' => 'Professors', 'recent' => [], 'others' => []],
    'Dumbledore' => ['label' => 'Dumbledore', 'recent' => [], 'others' => []],
];

foreach ($users as $user) {
    $role = $user['role'] ?? 'Student';

    if (!array_key_exists($role, $roleGroups)) {
        continue;
    }

    $user['unread_count'] = (int) ($user['unread_count'] ?? 0);
    $user['message_count'] = (int) ($user['message_count'] ?? 0);

    if ($user['message_count'] > 0) {
        $roleGroups[$role]['recent'][] = $user;
    } else {
        $roleGroups[$role]['others'][] = $user;
    }
}

foreach ($roleGroups as $role => $group) {
    usort($roleGroups[$role]['recent'], function ($a, $b) {
        return strcmp($b['last_message_at'] ?? '', $a['last_message_at'] ?? '');
    });

    $hasRecent = !empty($roleGroups[$role]['recent']);
    $hasOthers = !empty($roleGroups[$role]['others']);
    $roleGroups[$role]['visible'] = $includeAllUsers ? ($hasRecent || $hasOthers) : $hasRecent;
}

view('owlery/index', [
    'currentUser' => $currentUser,
    'search' => $search,
    'roleGroups' => $roleGroups,
    'activeUser' => $activeUser,
    'messages' => $messages,
    'owleryError' => Session::get('owlery_error'),
    'isNewConversation' => $isNewConversation,
]);
