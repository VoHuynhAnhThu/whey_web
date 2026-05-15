<?php

declare(strict_types=1);

class Question extends Model
{
    public function getAllWithAnswers(): array
{
    $sql = "SELECT q.*, u.role, u.email, a.body AS answer_body 
            FROM questions q 
            LEFT JOIN users u ON q.user_id = u.id 
            LEFT JOIN answers a ON a.question_id = q.id 
            ORDER BY q.created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

    public function create($data) 
    {
        // 1. Tạo một ID ngẫu nhiên bằng chuỗi (Ví dụ kết quả: q_64b7a9f8e1a2c)
        // Bạn có thể đổi 'q_' thành tiền tố bạn thích, hoặc bỏ trống uniqid()
        $newId = uniqid('q_'); 

        // 2. Thêm cột 'id' vào câu lệnh SQL
        $sql = "INSERT INTO questions (id, user_id, title, body) VALUES (:id, :user_id, :title, :body)";
        $stmt = $this->db->prepare($sql);
        
        // 3. Thực thi lệnh lưu kèm theo ID vừa tạo
        $stmt->execute([
            'id'      => $newId,
            'user_id' => $data['user_id'],
            'title'   => $data['title'],
            'body'    => $data['body']
        ]);

        // 4. Cực kỳ quan trọng: Trả về chính cái ID chuỗi đó 
        // để Controller biết đường mang đi lưu vào bảng 'answers'
        return $newId; 
    }

    public function getById(string $id): ?array 
    {

        $sql = "SELECT * FROM Questions WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: null; 
    }

    /**
     * Xóa một câu hỏi dựa vào ID
     */
    public function delete($id):bool
    {
        // 1. (Tùy chọn) Xóa các câu trả lời thuộc về câu hỏi này trước 
        // để tránh lỗi khóa ngoại (Foreign Key) nếu Database chưa set CASCADE DELETE
        $sqlDeleteAnswers = "DELETE FROM answers WHERE question_id = :id";
        $stmtAnswers = $this->db->prepare($sqlDeleteAnswers);
        $stmtAnswers->execute(['id' => $id]);

        // 2. Xóa câu hỏi
        $sqlDeleteQuestion = "DELETE FROM questions WHERE id = :id";
        $stmtQuestion = $this->db->prepare($sqlDeleteQuestion);
        
        return $stmtQuestion->execute(['id' => $id]);
    }
}