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
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/index.css">
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
        <!-- Contingut principal de la pàgina d'inici -->
        <h2>Quina finalitat té aquesta web?</h2>
        <!-- Breu descripció del propòsit del projecte -->
        <p>Aquesta web ha estat creada com a exemple amb finalitats acadèmiques i demostrativa de les meves habilitats
            tècniques en desenvolupament web.</p>
        <!-- Explicació de l'objectiu principal i bones pràctiques -->
        <p>L'objectiu principal d'aquest projecte és mostrar com es pot interactuar amb una base de dades SQL (MySQL, en
            aquest cas) utilitzant PHP sense frameworks externs, aplicant bones pràctiques de programació i seguretat.
        </p>
        <!-- Altres tecnologies utilitzades i arquitectura -->
        <p>A més de PHP, també s'utilitzen altres tecnologies web com HTML, CSS i JavaScript per a la presentació i la
            interactivitat. El projecte incorpora el patró d'arquitectura MVC, consultes preparades per evitar
            vulnerabilitats d'injecció SQL, gestió de sessions per a l'autenticació d'usuaris, i manipulació del DOM amb
            JavaScript per millorar l'experiència d'usuari.</p>
        <!-- Bones pràctiques de desenvolupament i mantenibilitat -->
        <p>Durant el desenvolupament, s'ha fet servir control de versions amb Git, i s'ha posat especial atenció a la
            documentació del codi, la modularitat i la reutilització de components. El projecte està pensat per ser
            escalable i fàcilment mantenible.</p>
        <!-- Funcionalitats implementades -->
        <p>El projecte inclou exemples pràctics d'autenticació d'usuaris, gestió de permisos, i implementació de
            funcionalitats CRUD (crear, llegir, actualitzar i eliminar) sobre diferents taules de la base de dades.
            També s'ha posat especial atenció a la seguretat, la validació de dades i la usabilitat de la interfície.
        </p>

        <!-- Informació sobre la base de dades utilitzada -->
        <h2>Quina base de dades s'utilitza?</h2>
        <p>La base de dades utilitzada és una base de dades SQL de mostra anomenada "employees", que es pot descarregar
            <a href="https://dev.mysql.com/doc/employee/en/" target="_blank">aquí</a>. Aquesta base de dades ha estat
            lleugerament modificada respecte a l'original: he afegit una taula d'usuaris per implementar un sistema
            d'autenticació i també he incorporat una sèrie de relacions que no existien.</p>
        <!-- Enllaç al codi font i contacte -->
        <p>Pots trobar el codi font d'aquesta web <a href="https://github.com/KrullVT/PHP_Native_Employees"
                target="_blank">aquí</a>.</p>
        <p>Si vols conèixer més detalls sobre el projecte, la seva arquitectura o el meu perfil professional, no dubtis
            a contactar-me.</p>
    </main>

    <?php
    // Incloem el footer per mostrar la informació legal i de contacte
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/footer.php";
    ?>

</body>

</html>