<?php
class Category extends Model {
    // Lấy tất cả danh mục để hiển thị trong Form thêm sản phẩm
    public function getAll() {
        $sql = "SELECT * FROM Categories ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}