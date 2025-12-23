<!DOCTYPE html>
<html lang="ca">

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
?>

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icona de la pàgina -->
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>IMG/php.png" type="image/x-icon">

    <!-- Fulls d'estil per donar format a la pàgina principal -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/style.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/contact.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/header.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/footer.css">

    <title>PHP - Exemple d'Employees</title>
</head>

<body>

    <?php
    // Incloem el header per mostrar la capçalera i menú de navegació
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/header.php";
    ?>

    <main id="main-index">

    </main>

    <?php
    // Incloem el footer per mostrar la informació legal i de contacte
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/footer.php";
    ?>

</body>

</html>