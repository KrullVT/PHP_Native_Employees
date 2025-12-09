<!DOCTYPE html>
<html lang="en">

<?php
// Iniciem la sessió per poder gestionar variables globals d'usuari i seguretat
session_start();

// Definim la base URL del projecte per construir rutes relatives correctes
if (isset($_SESSION['BASE_URL'])) {
    $baseUrl = rtrim($_SESSION['BASE_URL'], '/') . '/';
} else {
    $baseUrl = dirname($_SERVER['PHP_SELF']) . '/';
    // Guardem la base URL a la sessió per reutilitzar-la en altres pàgines
    $_SESSION['BASE_URL'] = $baseUrl;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icona de la pàgina -->
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>IMG/php.png" type="image/x-icon">

    <!-- Fulls d'estil per donar format a la pàgina -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/style.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/login.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/header.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/footer.css">

    <title>PHP - Exemple d'Employees</title>
</head>

<body>

    <?php
    // Incloem el header per mostrar la capçalera i menú de navegació
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/header.php";
    ?>

    <main id="main-login">
        <!-- Formulari d'inici de sessió per a usuaris -->
        <h2>Iniciar Sessió</h2>
        <form action="<?php echo $baseUrl; ?>Controllers/login_controller.php" method="POST" id="login-form">
            <!-- Camp per introduir el nom d'usuari -->
            <label for="username">Nom d'Usuari:</label>
            <input type="text" id="username" name="username" placeholder="El teu nom d'usuari" required>

            <!-- Camp per introduir la contrasenya -->
            <label for="password">Contrasenya:</label>
            <input type="password" id="password" name="password" placeholder="La teva contrasenya" required>
            <!-- Botó per enviar el formulari -->
            <button type="submit">Entrar</button>

            <!-- Opció per recordar l'usuari a la sessió -->
            <div id="login_remember">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Recorda'm</label>
            </div>

            <div id="login_register">
                <p>No tens compte? Registra't <a href="<?php echo $baseUrl; ?>Views/register.php">aquí</a></p>
            </div>

            <!-- Missatge d'error o informació del login -->
            <div id="login_message">
                <?php
                // Mostrem missatges d'error segons el paràmetre a la URL
                if (isset($_GET['error'])) {
                    if ($_GET['error'] === 'invalid_credentials') {
                        echo '<p class="error">Credencials invàlides. Si us plau, torna-ho a intentar.</p>';
                    } elseif ($_GET['error'] === 'csrf' || $_GET['error'] === 'csrf_mismatch') {
                        echo '<p class="error">Error de seguretat (CSRF). Torna-ho a intentar.</p>';
                    } elseif ($_GET['error'] === 'missing_fields') {
                        echo '<p class="error">Falten camps obligatoris.</p>';
                    } elseif ($_GET['error'] === 'db_connection') {
                        echo '<p class="error">Error de connexió amb la base de dades.</p>';
                    }
                }
                ?>
            </div>

            <!-- Token CSRF per protegir el formulari contra atacs de seguretat -->
            <input type="hidden" name="csrf_token" value="<?php
                                                            if (!isset($_SESSION['csrf_token'])) {
                                                                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                                            }
                                                            echo $_SESSION['csrf_token'];
                                                            ?>">
        </form>
    </main>

    <?php
    // Incloem el footer per mostrar la informació legal i de contacte
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/footer.php";
    ?>

</body>

</html>