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
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/employee.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/header.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/footer.css">

    <title>PHP - Exemple d'Employees</title>
</head>

<body>

    <?php
    // Incloem el header per mostrar la capçalera i menú de navegació
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/header.php";
    ?>

    <main id="main-employee">

        <?php
        // Comprovar si s'han rebut els paràmetres per veure, editar o eliminar un empleat
        if (isset($_GET['emp_no']) && isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'new':
                    // Codi per afegir un nou empleat
                    echo "<h2>Afegir Nou Empleat</h2>";
                    // Aquí es podria incloure un formulari per afegir un nou empleat
                    break;
                case 'view':
                    // Codi per veure els detalls de l'empleat
                    echo "<h2>Veure Empleat: " . htmlspecialchars($_GET['emp_no']) . "</h2>";
                    // Aquí es podria incloure més codi per mostrar la informació detallada
                    break;
                case 'edit':
                    // Codi per editar l'empleat
                    echo "<h2>Editar Empleat: " . htmlspecialchars($_GET['emp_no']) . "</h2>";
                    // Aquí es podria incloure un formulari per editar la informació
                    break;
                case 'delete':
                    // Codi per eliminar l'empleat
                    echo "<h2>Eliminar Empleat: " . htmlspecialchars($_GET['emp_no']) . "</h2>";
                    // Aquí es podria incloure una confirmació d'eliminació
                    break;
                default:
                    echo "<p>Acció desconeguda.</p>";
            }
        }
        ?>

    </main>

    <?php
    // Incloem el footer per mostrar la informació legal i de contacte
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/footer.php";
    ?>

</body>

</html>