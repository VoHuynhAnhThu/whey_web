<?php

declare(strict_types=1);

class Question extends Model
{
    public function getAllWithAnswers(): array
{
    $sql = "SELECT q.*, 
                   p.full_name as questioner_name, 
                   a.body as answer_body, 
                   a.created_at as answered_at 
            FROM Questions q 
            LEFT JOIN Profiles p ON q.user_id = p.user_id 
            LEFT JOIN Answers a ON q.id = a.question_id 
            ORDER BY q.created_at DESC";
            
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

    public function create(array $data): bool
    {
        $sql = "INSERT INTO Questions (id, user_id, title, body, created_at) 
                VALUES (UUID(), :user_id, :title, :body, NOW())";
        
        $stmt = $this->db->prepare($sql);
        

        return $stmt->execute([
            'user_id' => $data['user_id'] ?? null,
            'title'   => $data['title'],
            'body'    => $data['body']
        ]);
    }

    public function getById(string $id): ?array 
    {

        $sql = "SELECT * FROM Questions WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: null; 
    }
}