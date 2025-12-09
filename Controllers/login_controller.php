<?php

// Iniciem la sessió per gestionar variables globals d'usuari i seguretat
session_start();

// Definim la base URL del projecte per construir rutes relatives correctes
if (isset($_SESSION['BASE_URL'])) {
    $baseUrl = rtrim($_SESSION['BASE_URL'], '/') . '/';
} else {
    $baseUrl = dirname($_SERVER['PHP_SELF']) . '/';
    // Guardem la base URL a la sessió per reutilitzar-la en altres pàgines
    $_SESSION['BASE_URL'] = $baseUrl;
}

// Incloem el model d'usuaris per gestionar la base de dades
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . 'Models/usersCRUD.php';

// Comprovem si el formulari ha estat enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprovació del token CSRF per evitar atacs de seguretat
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ' . $baseUrl . 'Views/login.php?error=csrf');
        exit();
    }

    // Comprovació de camps obligatoris
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header('Location: ' . $baseUrl . 'Views/login.php?error=missing_fields');
        exit();
    }

    // Obtenim les dades del formulari
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']);

    // Connexió a la base de dades amb gestió d'errors utilitzant mysqli
    try {
        $dbConnection = new mysqli('localhost', 'root', '', 'employees_db');
        if ($dbConnection->connect_error) {
            throw new Exception('Error de connexió: ' . $dbConnection->connect_error);
        }
        // Creem una instància del model d'usuaris amb mysqli
        $usersCRUD = new usersCRUD($dbConnection);

        // Obtenim l'usuari per nom d'usuari
        $user = $usersCRUD->getUserByUsername($username);

        // Verifiquem les credencials
        if ($user && password_verify($password, $user['password'])) {
            // Credencials vàlides, iniciem la sessió
            $_SESSION['user'] = $user['username'];

            // Si l'usuari ha seleccionat "Recorda'm", establim una cookie per mantenir la sessió
            if ($rememberMe) {
                setcookie('remember_me', $user['username'], time() + (86400 * 30), "/"); // 30 dies
            }

            // Redirigim a la pàgina principal
            header('Location: ' . $baseUrl . 'index.php');
            exit();
        } else {
            // Credencials invàlides, redirigim al formulari de login amb un error
            header('Location: ' . $baseUrl . 'Views/login.php?error=invalid_credentials');
            exit();
        }
    } catch (Exception $e) {
        error_log('Error al login: ' . $e->getMessage());
        header('Location: ' . $baseUrl . 'Views/login.php?error=db_connection');
        exit();
    }
} else {
    // Si no s'ha enviat el formulari, redirigim al formulari de login
    header('Location: ' . $baseUrl . 'Views/login.php');
    exit();
}
