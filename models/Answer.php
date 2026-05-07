<?php

declare(strict_types=1);

class Answer extends Model
{
    public function create(array $data): bool
    {
        $sql = "INSERT INTO Answers (id, question_id, user_id, body, is_accepted, created_at) 
                VALUES (UUID(), :question_id, :user_id, :body, :is_accepted, NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'question_id' => $data['question_id'],
            'user_id'     => $data['user_id'] ?? null,
            'body'        => $data['body'],
            'is_accepted' => $data['is_accepted'] ?? 0
        ]);
    }

    public function getByQuestionId(string $questionId): array
    {
        $sql = "SELECT * FROM Answers WHERE question_id = :question_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['question_id' => $questionId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}