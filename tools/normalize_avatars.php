<?php
declare(strict_types=1);

require __DIR__ . '/../index.php'; // bootstraps app and autoload

try {
    $db = Database::connection();
    $stmt = $db->prepare('SELECT user_id, avatar_url FROM Profiles');
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $updated = 0;
    foreach ($rows as $row) {
        $userId = $row['user_id'];
        $avatar = trim((string) ($row['avatar_url'] ?? ''));
        if ($avatar === '')
            continue;

        // Extract basename (filename) to normalize
        $fileName = basename($avatar);
        if ($fileName === $avatar)
            continue; // already normalized

        $u = $db->prepare('UPDATE Profiles SET avatar_url = :avatar WHERE user_id = :id');
        $u->execute(['avatar' => $fileName, 'id' => $userId]);
        $updated++;
    }

    echo "Normalized avatars. Updated: {$updated}\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
