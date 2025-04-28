<?php
namespace App\Models;

use PDO;
use App\Config\Database;

class Message {
    public static function getAll() {
        $db = Database::getInstance();
    
        if ($_SESSION['role'] === 'admin') {
            $query = "SELECT m.*, u.username, u.role 
                    FROM messages m 
                    JOIN users u ON m.user_id = u.id 
                    ORDER BY m.created_at ASC";
        } 
        else {
            $query = "SELECT m.*, u.username, u.role 
                    FROM messages m 
                    JOIN users u ON m.user_id = u.id 
                    WHERE m.is_deleted = FALSE 
                    ORDER BY m.created_at ASC";
        }
        
        return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($userId, $content) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO messages (user_id, content) VALUES (:user_id, :content)");
        $stmt->execute([':user_id' => $userId, ':content' => $content]);
        return $db->lastInsertId();
    }

    public static function delete($id) {
        $db = Database::getInstance();
        
        if ($_SESSION['role'] === 'admin') {
            $stmt = $db->prepare("UPDATE messages SET is_deleted = TRUE WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        }
    }
}