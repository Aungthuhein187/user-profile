<?php

namespace Libs\Database;

use PDO;
use PDOException;

class UsersTable
{
    private PDO|null|string $db = null;

    public function __construct(MySql $db)
    {
        $this->db = $db->connect();
    }

    public function insert($data): string
    {
        try {
            $query = "INSERT INTO users (
         name, email, phone, address, password, role_id, created_at
         ) VALUES (:name, :email, :phone, :address, :password, :role_id, NOW())";

            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function getAll(): array|string
    {
        try {
            $query = "SELECT users.*, roles.name AS role, roles.value
                FROM users LEFT JOIN roles ON users.role_id = roles.id";
            $statement = $this->db->prepare($query);
            $statement->execute();

            return $statement->fetchAll();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function findByEmailAndPassword(string $email, string $password)
    {
        try {
            $query = "SELECT users.*, roles.name AS role, roles.value 
                FROM users LEFT JOIN roles ON users.role_id=roles.id 
                WHERE users.email=:email AND users.password=:password";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":email" => $email,
                ":password" => $password,
            ]);

            $row = $statement->fetch();
            return $row ?? false;

        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function updatePhoto($id, $name): int
    {
        $query = "UPDATE users SET photo=:name WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->execute([':name' => $name, ':id' => $id]);
        return $statement->rowCount();
    }

    public function suspended($id)
    {
        try {
            $query = "SELECT * FROM users WHERE users.id=:id AND users.suspended=1";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":id" => $id,
            ]);

            $row = $statement->fetch();
            return $row ?? false;

        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function suspend($id): int|string
    {
        try {
            $query = "UPDATE users SET suspended=1 WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([':id' => $id]);

            return $statement->rowCount();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function unsuspend($id): int|string
    {
        try {
            $query = "UPDATE users SET suspended=0 WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([':id' => $id]);

            return $statement->rowCount();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function changeRole($id, $role): int
    {
        try {
            $query = "UPDATE users SET role_id = :role WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([':id' => $id, ':role' => $role]);

            return $statement->rowCount();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->execute([':id' => $id]);

            return $statement->rowCount();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
