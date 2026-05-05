<?php
class ContactModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    // --- HÀM CŨ (Thêm lại để Controller hiện tại không bị lỗi) ---
    public function getAllContacts() {
        $stmt = $this->db->prepare("SELECT * FROM contacts ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- HÀM MỚI CHO PHÂN TRANG ---
    public function getPaginatedContacts(int $limit, int $offset): array {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(): int {
        $sql = "SELECT COUNT(*) FROM contacts";
        return (int) $this->db->query($sql)->fetchColumn();
    }

    // 3. Các hàm cũ của bạn (giữ nguyên logic)
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE contacts SET status = :status WHERE id = :id");
        return $stmt->execute([':id' => $id, ':status' => $status]);
    }

    public function deleteContact($id) {
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO contacts (full_name, email, phone, subject, message) 
                VALUES (:full_name, :email, :phone, :subject, :message)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email'     => $data['email'],
            ':phone'     => $data['phone'] ?? null,
            ':subject'   => $data['subject'] ?? null,
            ':message'   => $data['message']
        ]);
    }
}