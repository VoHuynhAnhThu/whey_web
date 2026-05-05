<?php

class SettingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Lấy toàn bộ cấu hình website từ bảng settings
     */
    public function getAllSettings() {
        // Tên bảng phải khớp với database (viết thường)
        $sql = "SELECT * FROM settings"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSetting($key, $value) {
    // Sửa 'setting_value' thành 'value' và 'setting_key' thành 'key'
    $sql = "UPDATE settings SET value = :value WHERE `key` = :key";
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
        ':key' => $key,
        ':value' => $value
    ]);
}
}

