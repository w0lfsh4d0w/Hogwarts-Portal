<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class MessageModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function listUsersForMessaging(int $currentUserId, ?string $search = null, bool $includeAll = false): array
    {
        $params = [
            'current_id' => $currentUserId,
        ];

        $where = 'WHERE u.user_id <> :current_id';

        if ($search) {
            $where .= ' AND (u.user_name LIKE :search OR u.email LIKE :search)';
            $params['search'] = '%' . $search . '%';
        }

        if (!$includeAll && !$search) {
            $where .= ' AND m.message_count IS NOT NULL';
        }

        $query = 'SELECT
                u.user_id,
                u.user_name,
                u.email,
                u.role,
                COALESCE(m.message_count, 0) AS message_count,
                COALESCE(m.unread_count, 0) AS unread_count,
                m.last_message_at
            FROM User AS u
            LEFT JOIN (
                SELECT
                    CASE
                        WHEN sender_id = :current_id THEN receiver_id
                        ELSE sender_id
                    END AS other_user_id,
                    COUNT(*) AS message_count,
                    SUM(CASE WHEN receiver_id = :current_id AND is_read = 0 THEN 1 ELSE 0 END) AS unread_count,
                    MAX(sent_at) AS last_message_at
                FROM Message
                WHERE sender_id = :current_id OR receiver_id = :current_id
                GROUP BY other_user_id
            ) AS m
                ON m.other_user_id = u.user_id
            ' . $where . '
            ORDER BY u.user_name ASC';

        return $this->db->query($query, $params)->get();
    }

    public function findUserById(int $userId): ?array
    {
        return $this->db->query('SELECT user_id, user_name, email, role
                FROM User
                WHERE user_id = :user_id
                LIMIT 1
            ', [
            'user_id' => $userId,
        ])->find();
    }

    public function getConversation(int $currentUserId, int $otherUserId): array
    {
        return $this->db->query('SELECT
                Message.message_id,
                Message.sender_id,
                Message.receiver_id,
                Message.message_body,
                Message.sent_at,
                Message.is_read,
                sender.user_name AS sender_name,
                receiver.user_name AS receiver_name
            FROM Message
            JOIN User AS sender ON Message.sender_id = sender.user_id
            JOIN User AS receiver ON Message.receiver_id = receiver.user_id
            WHERE (Message.sender_id = :current_id AND Message.receiver_id = :other_id)
               OR (Message.sender_id = :other_id AND Message.receiver_id = :current_id)
            ORDER BY Message.sent_at ASC
        ', [
            'current_id' => $currentUserId,
            'other_id' => $otherUserId,
        ])->get();
    }

    public function markConversationRead(int $currentUserId, int $otherUserId): void
    {
        $this->db->query('UPDATE Message
                SET is_read = 1
                WHERE receiver_id = :current_id
                    AND sender_id = :other_id
                    AND is_read = 0
            ', [
            'current_id' => $currentUserId,
            'other_id' => $otherUserId,
        ]);
    }

    public function sendMessage(int $senderId, int $receiverId, string $body): void
    {
        $this->db->query('INSERT INTO Message (sender_id, receiver_id, message_body)
                VALUES (:sender_id, :receiver_id, :message_body)
            ', [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message_body' => $body,
        ]);
    }
}
