<?php

declare(strict_types = 1);
    
class Settings extends Model
{
    public function getByPage(string $page): array
    {
        $sql = "SELECT `key`, `value` FROM Settings WHERE page = :page";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['page'=>$page]);

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function getByKey(string $key): ?string
    {
        $sql = "SELECT `value` FROM Settings WHERE key = :key";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['key'=>$key]);
        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        return $result ? $result['value'] : null;
    }

    public function updateValue(string $key, string $value): bool
    {
        $sql = "UPDATE Settings SET `value` = :value WHERE `key` = :key";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'key'=>$key,
            'value'=>$value
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM Settings";
        $stmt = $this->db->prepare($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>