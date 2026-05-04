<?php

declare(strict_types=1);

class News extends Model
{
    public function getAllPublished(int $limit = 10, int $offset = 0): array
    {
        $limit = max(1, (int) $limit);
        $offset = max(0, (int) $offset);

        $sql = "SELECT n.id, n.title, n.slug, n.description, n.content, n.featured_image, n.author_id,
                       n.status, n.view_count, n.created_at, n.updated_at,
                       p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
                WHERE n.status = 'published'
                ORDER BY n.created_at DESC
                LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function searchPublished(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $limit = max(1, (int) $limit);
        $offset = max(0, (int) $offset);
        $keyword = '%' . $keyword . '%';

        $sql = "SELECT n.id, n.title, n.slug, n.description, n.content, n.featured_image, n.author_id,
                                             n.status, n.view_count, n.created_at, n.updated_at,
                                             p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
                                WHERE n.status = 'published'
                                    AND (n.title LIKE :keyword OR n.description LIKE :keyword OR n.content LIKE :keyword)
                ORDER BY n.created_at DESC
                LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'keyword' => $keyword,
        ]);

        return $stmt->fetchAll();
    }

    public function countPublished(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM News WHERE status = 'published'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function countSearchPublished(string $keyword): int
    {
        $sql = "SELECT COUNT(*) AS total FROM News
            WHERE status = 'published'
              AND (title LIKE :keyword OR description LIKE :keyword OR content LIKE :keyword)";

        $stmt = $this->db->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->execute(['keyword' => $keyword]);
        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT n.id, n.title, n.slug, n.description, n.content, n.featured_image,
                   n.author_id, n.status, n.created_at, n.updated_at,
                   n.view_count, p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
            WHERE n.slug = :slug AND n.status = 'published'
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public function findById(string $id): ?array
    {
        $sql = 'SELECT n.*, p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
                WHERE n.id = :id
                LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public function incrementViewCount(string $id): void
    {
        $sql = 'UPDATE News SET view_count = view_count + 1 WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function create(array $data): string
    {
        $id = Str::uuid();

        $sql = 'INSERT INTO News (
                    id, title, slug, description, content, featured_image,
                    author_id, status, view_count, created_at, updated_at
                ) VALUES (
                    :id, :title, :slug, :description, :content, :featured_image,
                    :author_id, :status, :view_count, NOW(), NULL
                )';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'],
            'featured_image' => $data['featured_image'] ?? null,
            'author_id' => $data['author_id'],
            'status' => $data['status'] ?? 'draft',
            'view_count' => $data['view_count'] ?? 0,
        ]);

        return $id;
    }

    public function update(string $id, array $data): void
    {
        $sql = 'UPDATE News SET
                    title = :title,
                    slug = :slug,
                    description = :description,
                    content = :content,
                    featured_image = :featured_image,
                    author_id = :author_id,
                    status = :status,
                    updated_at = NOW()
                WHERE id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'],
            'featured_image' => $data['featured_image'] ?? null,
            'author_id' => $data['author_id'],
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    public function delete(string $id): void
    {
        $sql = 'DELETE FROM News WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function getAll(int $limit = 10, int $offset = 0): array
    {
        $limit = max(1, (int) $limit);
        $offset = max(0, (int) $offset);

        $sql = "SELECT n.id, n.title, n.slug, n.description, n.featured_image, n.author_id,
                       n.status, n.created_at, n.updated_at, n.view_count,
                       p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
                ORDER BY n.created_at DESC
                LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function search(string $keyword, int $limit = 10, int $offset = 0): array
    {
        $limit = max(1, (int) $limit);
        $offset = max(0, (int) $offset);
        $keyword = '%' . $keyword . '%';

        $sql = "SELECT n.id, n.title, n.slug, n.description, n.featured_image, n.author_id,
                  n.status, n.created_at, n.updated_at, n.view_count,
                  p.full_name AS author_name
                FROM News n
                LEFT JOIN Profiles p ON p.user_id = n.author_id
              WHERE n.title LIKE :keyword OR n.description LIKE :keyword OR n.content LIKE :keyword
                ORDER BY n.created_at DESC
                LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);

        return $stmt->fetchAll();
    }

    public function count(): int
    {
        $sql = 'SELECT COUNT(*) as total FROM News';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function countSearch(string $keyword): int
    {
        $sql = 'SELECT COUNT(*) as total FROM News
                WHERE title LIKE :keyword OR description LIKE :keyword OR content LIKE :keyword';

        $stmt = $this->db->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->execute(['keyword' => $keyword]);
        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function slugExists(string $slug, ?string $ignoreId = null): bool
    {
        $sql = 'SELECT id FROM News WHERE slug = :slug';
        $params = ['slug' => $slug];

        if ($ignoreId !== null && $ignoreId !== '') {
            $sql .= ' AND id <> :ignore_id';
            $params['ignore_id'] = $ignoreId;
        }

        $sql .= ' LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetch();
    }
}