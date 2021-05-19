<?php
require_once __DIR__ . '/vendor/autoload.php';

function dlog($arg) {
    error_log(print_r($arg, true));
}

class Database extends SQLite3 {
    function __construct() {
        $this->open('db.db');
        $this->exec("CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            body TEXT NOT NULL,
            points INTEGER NOT NULL
        );");
        $this->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        );");
    }

    public function registerUser($username, $password) {
        $statement = $this->prepare("INSERT INTO users(username, password) VALUES (:username, :password)");
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        return false !== $statement->execute();
    }

    public function login($username, $password) {
        $statement = $this->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bindValue(1, $username);
        $result = $statement->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if ($row != false && password_verify($password, $row['password']))
            return $row;
        return false;
    }

    public function insertPost($title, $body) {
        $statement = $this->prepare("INSERT INTO posts(title, body, points) VALUES (:title, :body, 0)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':body', $body);
        return false !== $statement->execute();
    }

    public function clearDb() {
        $this->exec("DELETE FROM posts");
    }

    public function getPosts() {
        $rows = array();
        $result = $this->query("SELECT * FROM posts");
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
            array_push($rows, $row);
        return $rows;
    }

    public function vote($id, $amm) {
        $statement = $this->prepare("UPDATE posts SET points = points + ? WHERE id = ?");
        $statement->bindValue(1, $amm);
        $statement->bindValue(2, $id);
        return false !== $statement->execute();
    }
}

$db = new Database();
