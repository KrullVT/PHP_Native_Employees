<!-- Capçalera principal de la web -->
<header>
    <div id="title">
        <!-- Bloc amb informació del desenvolupador i branding -->
        <div id="title_dc">
            <p>Desenvolupat per</p>
            <a href="https://devcon.cat" target="_blank" class="devcon-link">
                <b>DEV<b id="dc_enfasis">CON</b></b>
            </a>
            <p>Software Solutions</p>
        </div>
        <!-- Bloc amb el nom i descripció del projecte -->
        <div id="title_text">
            <a href="<?php echo $baseUrl; ?>index.php" id="home-link">
                <h1>Employees</h1>
            </a>
            <h2>Gestió d'empleats</h2>
        </div>
        <!-- Bloc d'autenticació d'usuari: mostra login/logout segons l'estat de la sessió -->
        <div id="title_login">
            <?php
            // Si l'usuari està autenticat, mostra el seu nom i l'opció de tancar sessió
            if (isset($_SESSION['user'])) {
                echo '<span>Benvingut, ' . htmlspecialchars($_SESSION['user']) . '!</span> ';
                echo '<a href="' . $baseUrl . 'Controllers/logoutController.php" class="login-link">Tancar sessió</a>';
            } else {
                // Si no està autenticat, mostra les opcions d'iniciar sessió o registrar-se
                echo '<a href="' . $baseUrl . 'Views/login.php" class="login-link">Iniciar sessió</a> | <a href="' . $baseUrl . 'Views/register.php" class="login-link">Registrar-se</a>';
            }
            ?>
        </div>
    </div>
    <!-- Menú de navegació principal de la web -->
    <nav>
        <ul>
            <li class="nav-link active"><a href="<?php echo $baseUrl; ?>index.php">Inici</a></li>
            <li class="nav-link"><a href="<?php echo $baseUrl; ?>Views/users.php">Usuaris</a></li>
            <li class="nav-link"><a href="<?php echo $baseUrl; ?>Views/employees.php">Treballadors</a></li>
            <li class="nav-link"><a href="<?php echo $baseUrl; ?>Views/departments.php">Departaments</a></li>
            <li class="nav-link"><a href="<?php echo $baseUrl; ?>Views/contact.php">Contacte</a></li>
        </ul>
    </nav>
</header>