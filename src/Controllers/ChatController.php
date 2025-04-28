<?php
namespace App\Controllers;

use App\View;
use App\Models\Message;

class ChatController 
{
    public function showChat()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        echo (new View('chat.php'))->render();
    }

    public function getMessages() {
        header('Content-Type: application/json');
        echo json_encode(Message::getAll());
        exit;
    }

    public function sendMessage() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        $content = isset($data['content']) ? $this->sanitizeInput($data['content']) : '';
        
        if (!empty($content)) {
            Message::create($_SESSION['user_id'], $content);
            http_response_code(201);
            echo json_encode(['status' => 'success']);
            exit;
        }

        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty']);
        exit;
    }

    public function deleteMessage($id) {
        if (Message::delete($id)) {
            http_response_code(200);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
        }
        exit;
    }

    private function sanitizeInput(string $input): string {
        $cleaned = strip_tags($input);
        $cleaned = htmlspecialchars($cleaned, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $cleaned = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleaned);
    
        return trim($cleaned);
    }
}