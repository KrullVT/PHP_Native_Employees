<?php

class usersCRUD
{
    private $conn; // Connexió a la base de dades (mysqli)

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // Mètode per obtenir tots els usuaris
    public function getAllUsers()
    {
        try {
            $result = $this->conn->query("SELECT * FROM users");
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            error_log('Error obtenint usuaris: ' . $e->getMessage());
            return [];
        }
    }

    // Mètode per obtenir un usuari per nom d'usuari
    public function getUserByUsername($username)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log('Error obtenint usuari: ' . $e->getMessage());
            return null;
        }
    }

    // Mètode per crear un nou usuari
    public function createUser($username, $password, $email, $role)
    {
        // Validació extra: email vàlid i força de contrasenya
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log('Email invàlid: ' . $email);
            return false;
        }
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            error_log('Contrasenya dèbil.');
            return false;
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param('ssss', $username, $hashedPassword, $email, $role);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error creant usuari: ' . $e->getMessage());
            return false;
        }
    }

    // Mètode per actualitzar la informació d'un usuari
    public function updateUser($id, $username, $email, $role)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log('Email invàlid: ' . $email);
            return false;
        }
        try {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param('sssi', $username, $email, $role, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error actualitzant usuari: ' . $e->getMessage());
            return false;
        }
    }

    // Mètode per eliminar un usuari
    public function deleteUser($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error eliminant usuari: ' . $e->getMessage());
            return false;
        }
    }

    // Mètode per verificar les credencials d'un usuari
    public function verifyCredentials($username, $password)
    {
        try {
            $user = $this->getUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (Exception $e) {
            error_log('Error verificant credencials: ' . $e->getMessage());
            return false;
        }
    }

    // Mètode per actualitzar l'últim inici de sessió
    public function updateLastLogin($id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error actualitzant last_login: ' . $e->getMessage());
            return false;
        }
    }
}