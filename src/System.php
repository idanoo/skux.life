<?php

namespace Skuxlife;

class System {
    /**
     * Returns array of photo paths
     *
     * @return array
     */
    public function getPhotos(int $limit): array {
        $db = new \PDO('sqlite:../db.sqlite3');
        $result = $db->query('SELECT photo_name  FROM photos ORDER BY created DESC limit ' . $limit);
        $data = [];

        foreach ($result as $row) {
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
        $sql = 'INSERT INTO photos(photo_name, created) VALUES(:photo_name, date())';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':photo_name', $hash);
        $stmt->execute();
    }
}