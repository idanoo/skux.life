<?php

namespace Skuxlife;

class System {
    /**
     * Returns array of photo paths
     *
     * @return array
     */
    public function getPhotos(int $limit, ?int $forUser = null): array {
        $db = new \PDO('sqlite:../db.sqlite3');
        if (!is_null($forUser)) {
            $stmt = $db->prepare('SELECT photo_name FROM photos WHERE created_user = :created_user ORDER BY created DESC limit :limit');
            $stmt->execute(['created_user' => $forUser, 'limit' => $limit]);
        } else {
            $stmt = $db->prepare('SELECT photo_name FROM photos ORDER BY created DESC limit :limit');
            $stmt->execute(['limit' => $limit]);
        }
        $rows = $stmt->fetchAll();

        $data = [];
        foreach ($rows as $row) {
            $data[] = $row['photo_name'];
        }

        return $data;
    }

    /**
     * Returns 40 char hash
     *
     * @return strsing
     */
    public function generateUid(): string {
        return bin2hex(random_bytes(20));
    }

    /**
     * Add new pic to db
     *
     * @param string $hash
     * 
     * @return void
     */
    public function add(string $hash): void {
        $db = new \PDO('sqlite:../db.sqlite3');
        $sql = 'INSERT INTO photos(photo_name, created, created_user) VALUES(:photo_name, date(), :created_user)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':photo_name', $hash);
        $stmt->bindValue(':created_user', $_SESSION['user_id']);
        $stmt->execute();
    }

    /**
     * Returns current URL for redirects
     */
    public static function getURL(string $path = '/'): string {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : ' http://';
        $url = $scheme . $_SERVER['HTTP_HOST'] . $path;

        if (str_contains($_SERVER['HTTP_HOST'], '127.0.0.1') && $path !== '/') {
            return $url . '.php';
        }
        return $url;
    }

    /**
     * Delete da image >:
     */
    public static function delete(string $hash): void {
        // Only match our hashes exactly.
        $matches = [];
        preg_match('/^([a-z0-9]{40}(\-thumb)?\.[a-z]{3,4})$/', $hash, $matches);

        if (count($matches) > 0) {
            $db = new \PDO('sqlite:../db.sqlite3');

            // Check it's for curr user.
            $db = new \PDO('sqlite:../db.sqlite3');
            $stmt = $db->prepare('SELECT photo_name FROM photos WHERE photo_name = :photo_name AND created_user = :created_user');
            $stmt->execute(['created_user' => $_SESSION['user_id'], 'photo_name' => $hash]);
            $rows = $stmt->fetchAll();
        
            if (count($rows) > 0) {
                // Delete DB row
                $stmt = $db->prepare('DELETE FROM photos WHERE photo_name = :photo_name');
                $stmt->bindValue(':photo_name', $hash);
                $stmt->execute();

                // Delete files!
                @unlink('uploads/' . $hash);
                @unlink('uploads/' . str_replace('.', '-thumb.', $hash));
            }
        }
    }
}