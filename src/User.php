<?php

namespace Skuxlife;

class User {
    /**
     * getUserId if exists
     *
     * @param string $username
     *
     * @return ?int
     */
    public static function getUserId(string $username): ?int {
        $db = new \PDO('sqlite:../db.sqlite3');
        $stmt = $db->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            return $rows[0]['id'];
        }

        return null;
    }
    /**
     * Creates new user
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public static function register(string $username, string $password): bool {
        // If exists, bounce!!
        if (static::getUserId($username)) {
            error_log('Trying to register ' . $username . ' but already exists :3');
            return false;
        }

        $db = new \PDO('sqlite:../db.sqlite3');
        $stmt = $db->prepare('INSERT INTO users (username,password) VALUES (:username, :password)');
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), \PDO::PARAM_STR);
        $id = $stmt->execute();
        error_log($id);

        if (!empty($id)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
         
        return false;
    }

    /**
     * Logs into an existing account
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public static function login(string $username, string $password): bool {
        $db = new \PDO('sqlite:../db.sqlite3');
        $stmt = $db->prepare('SELECT id, password FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $rows = $stmt->fetchAll();
        if (empty($rows)) {
            return false;
        }

        if (password_verify($password, $rows[0]['password'])) {
            $_SESSION['user_id'] = $rows[0]['id'];
            return true;
        }

        return false;
    }

    /**
     * Checks if user is logged in
     *
     * @return bool
     */
    public static function loggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }
}