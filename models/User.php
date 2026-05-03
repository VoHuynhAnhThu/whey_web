<?php

declare(strict_types=1);

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $sql = 'SELECT id, email, password, role, status FROM Users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user !== false ? $user : null;
    }

    public function findById(string $id): ?array
    {
        $sql = 'SELECT u.id, u.email, u.role, u.status, p.full_name, p.avatar_url, p.phone, p.address, p.bio
                FROM Users u
                LEFT JOIN Profiles p ON p.user_id = u.id
                WHERE u.id = :id
                LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user !== false ? $user : null;
    }

    public function create(string $email, string $passwordHash, string $role = 'member'): string
    {
        $id = Str::uuid();

        $sql = 'INSERT INTO Users (id, email, password, role, status, created_at)
                VALUES (:id, :email, :password, :role, :status, NOW())';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role,
            'status' => 'active',
        ]);

        $this->createEmptyProfile($id);

        return $id;
    }

    public function updateProfile(string $userId, array $payload): void
    {
        $sql = 'INSERT INTO Profiles (user_id, full_name, avatar_url, phone, address, bio)
                VALUES (:user_id, :full_name, :avatar_url, :phone, :address, :bio)
                ON DUPLICATE KEY UPDATE
                    full_name = VALUES(full_name),
                    avatar_url = VALUES(avatar_url),
                    phone = VALUES(phone),
                    address = VALUES(address),
                    bio = VALUES(bio)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'full_name' => $payload['full_name'],
            'avatar_url' => $payload['avatar_url'],
            'phone' => $payload['phone'],
            'address' => $payload['address'],
            'bio' => $payload['bio'],
        ]);
    }

    private function createEmptyProfile(string $userId): void
    {
        $stmt = $this->db->prepare('INSERT INTO Profiles (user_id) VALUES (:user_id)');
        $stmt->execute(['user_id' => $userId]);
    }

    public function getAll(): array
    {
        $sql = 'SELECT u.id, u.email, u.role, u.status, u.created_at, p.full_name, p.phone
                FROM Users u
                LEFT JOIN Profiles p ON u.id = p.user_id 
                ORDER BY u.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateAccount(string $id, array $data): bool
    {
        $sql = 'UPDATE Users 
                SET email = :email,
                    role = :role,
                    status = :status
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' =>  $id,
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status']
        ]);
    }
    
    public function delete(string $id): bool
    {
        $stmtProfile = $this->db->prepare('DELETE FROM Profiles WHERE user_id = :id');
        $stmtProfile->execute(['id' => $id]);

        $sql = 'DELETE FROM Users WHERE id = :id';
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id'=>$id]);
    }
    
}
