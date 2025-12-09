<?php

class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $role;
    private $created_at;
    private $updated_at;
    private $last_login;

    // Constructor amb validació extra
    public function __construct($id, $username, $password, $email, $role, $created_at, $updated_at, $last_login)
    {
        $this->id = $id;
        $this->username = $username;
        // Validació de força de contrasenya
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            error_log('Contrasenya dèbil en User::__construct');
        }
        $this->password = $password;
        // Validació d'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log('Email invàlid en User::__construct: ' . $email);
        }
        $this->email = $email;
        $this->role = $role;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->last_login = $last_login;
    }

    // Getters i Setters per a cada propietat
    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function getLastLogin()
    {
        return $this->last_login;
    }
}
