<?php

declare(strict_types=1);

class Comment extends Model
{
    /**
     * Lấy các bình luận được duyệt cho bài viết
     */
    public function getApprovedComments(string $newsId, int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT c.id, c.news_id, c.user_id, c.rating, c.content, c.created_at, 
                       p.full_name as user_name, p.avatar_url as user_avatar
                FROM Comments c
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                WHERE c.news_id = :news_id AND c.status = :status
                ORDER BY c.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'news_id' => $newsId,
            'status' => 'approved',
            // 'limit' => $limit,
            // 'offset' => $offset,
        ]);

        $rows = $stmt->fetchAll();

        // Normalize avatar URLs to full public URLs using asset(), keeping absolute URLs intact
        foreach ($rows as &$r) {
            $avatar = trim((string) ($r['user_avatar'] ?? ''));
            if ($avatar === '') {
                $r['user_avatar'] = '';
                continue;
            }
            if (filter_var($avatar, FILTER_VALIDATE_URL)) {
                $r['user_avatar'] = $avatar;
            } else {
                $r['user_avatar'] = asset('uploads/avatars/' . basename($avatar));
            }
        }

        return $rows;
    }

    public function countApprovedComments(string $newsId): int
    {
        $sql = 'SELECT COUNT(*) as total FROM Comments WHERE news_id = :news_id AND status = :status';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'news_id' => $newsId,
            'status' => 'approved',
        ]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Tạo bình luận mới
     */
    public function create(array $data): string
    {
        $id = Str::uuid();

        $sql = 'INSERT INTO Comments (id, news_id, user_id, rating, content, status, created_at)
                VALUES (:id, :news_id, :user_id, :rating, :content, :status, NOW())';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'news_id' => $data['news_id'],
            'user_id' => $data['user_id'],
            'rating' => $data['rating'] ?? 0,
            'content' => $data['content'],
            'status' => 'approved',
        ]);

        return $id;
    }

    /**
     * Lấy tất cả bình luận (admin)
     */
    public function getAll(int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT c.id, c.news_id, c.user_id, c.rating, c.content, c.status, c.created_at,
                       u.email, p.full_name as user_name, n.title as news_title
                FROM Comments c
                LEFT JOIN Users u ON u.id = c.user_id
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                LEFT JOIN News n ON n.id = c.news_id
                ORDER BY c.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            // 'limit' => $limit,
            // 'offset' => $offset,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Lấy bình luận theo trạng thái
     */
    public function getByStatus(string $status, int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT c.id, c.news_id, c.user_id, c.rating, c.content, c.status, c.created_at,
                       u.email, p.full_name as user_name, n.title as news_title
                FROM Comments c
                LEFT JOIN Users u ON u.id = c.user_id
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                LEFT JOIN News n ON n.id = c.news_id
                WHERE c.status = :status
                ORDER BY c.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'status' => $status,
            // 'limit' => $limit,
            // 'offset' => $offset,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Đếm bình luận theo trạng thái
     */
    public function countByStatus(string $status): int
    {
        $sql = 'SELECT COUNT(*) as total FROM Comments WHERE status = :status';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['status' => $status]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Đếm tất cả bình luận
     */
    public function count(): int
    {
        $sql = 'SELECT COUNT(*) as total FROM Comments';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Lấy chi tiết bình luận
     */
    public function findById(string $id): ?array
    {
        $sql = 'SELECT c.*, u.email, p.full_name as user_name, n.title as news_title
                FROM Comments c
                LEFT JOIN Users u ON u.id = c.user_id
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                LEFT JOIN News n ON n.id = c.news_id
                WHERE c.id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Cập nhật trạng thái bình luận
     */
    public function updateStatus(string $id, string $status): void
    {
        $sql = 'UPDATE Comments SET status = :status, updated_at = NOW() WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'status' => $status,
        ]);
    }

    /**
     * Xóa bình luận
     */
    public function delete(string $id): void
    {
        $sql = 'DELETE FROM Comments WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Tìm kiếm bình luận (admin)
     */
    public function search(string $keyword, int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT c.id, c.news_id, c.user_id, c.rating, c.content, c.status, c.created_at,
                       u.email, p.full_name as user_name, n.title as news_title
                FROM Comments c
                LEFT JOIN Users u ON u.id = c.user_id
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                LEFT JOIN News n ON n.id = c.news_id
                WHERE p.full_name LIKE :keyword OR n.title LIKE :keyword OR c.content LIKE :keyword
                ORDER BY c.created_at DESC
                LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->db->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->execute([
            'keyword' => $keyword,
            // 'limit' => $limit,
            // 'offset' => $offset,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Đếm bình luận tìm kiếm
     */
    public function countSearch(string $keyword): int
    {
        $sql = 'SELECT COUNT(*) as total FROM Comments c
                LEFT JOIN Profiles p ON p.user_id = c.user_id
                LEFT JOIN News n ON n.id = c.news_id
                WHERE p.full_name LIKE :keyword OR n.title LIKE :keyword OR c.content LIKE :keyword';

        $stmt = $this->db->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->execute(['keyword' => $keyword]);
        $result = $stmt->fetch();
        return (int) $result['total'];
    }
}
