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
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>Assets/img/php.png" type="image/x-icon">

    <!-- Fulls d'estil per donar format a la pàgina principal -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/style.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/employees.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/header.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>CSS/footer.css">

    <title>PHP - Exemple d'Employees</title>
</head>

<body>

    <?php
    // Incloem el header per mostrar la capçalera i menú de navegació
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/header.php";
    ?>

    <main id="main-employees">

        <div id="emp-layout">
            <div id="emp-layout-left">
                <h2>Menú</h2>
                <ul id="emp-llista-principal" class="emp-llista">
                    <li>
                        <img src="<?php echo $baseUrl; ?>Assets/icons/employee-group-svgrepo-com.svg"
                            alt="Icona de treballadors" class="m-link-icon">
                        <a href="<?php echo $baseUrl; ?>Views/employees.php">Tots els treballadors</a>
                    </li>
                    <li>
                        <img src="<?php echo $baseUrl; ?>Assets/icons/add.svg" alt="Icona d'afegir treballador"
                            class="m-link-icon">
                        <a href="<?php echo $baseUrl; ?>Views/employee.php?action=new">Afegir treballador</a>
                    </li>
                    <li>
                        <img src="<?php echo $baseUrl; ?>Assets/icons/find.svg" alt="Icona de buscar treballador"
                            class="m-link-icon">
                        <a href="#">Buscar treballador</a>
                    </li>
                    <li>
                        <img src="<?php echo $baseUrl; ?>Assets/icons/statistics-svgrepo-com"
                            alt="Icona d'estadístiques" class="m-link-icon">
                        <a href="#">Estadístiques</a>
                    </li>
                </ul>

                <ul id="emp-llista-filtre" class="emp-llista">

                    <form id="emp-filter-form" method="POST"
                        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <li>
                            <h3>Departaments</h3>
                        </li>
                        <?php

                        include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Models/departmentsCRUD.php";

                        $depts = new DepartmentCRUD();
                        $departments = $depts->getAllDepartments();

                        foreach ($departments as $department) {
                            echo '<li class="emp-llista-element">
                            <input type="checkbox" name="emp-filtre-dept" id="emp-filtre-dept-' . htmlspecialchars($department->getDeptNo()) . '" checked>
                            <label for="emp-filtre-dept-' . htmlspecialchars($department->getDeptNo()) . '">' . htmlspecialchars($department->getDeptName()) . '</label>
                            </li>';
                        }

                        ?>

                        <li>
                            <h3>Càrrecs</h3>
                        </li>



                        <li>
                            <input type="submit" value="Aplicar filtres" id="emp-apply-filters-btn">
                        </li>
                    </form>

                </ul>
            </div>

            <div id="emp-layout-center">
                <h2>Gestió de treballadors</h2>
                <p>Aquesta secció està dedicada a la gestió dels treballadors de l'empresa. Aquí podràs afegir, editar i
                    eliminar treballadors, així com visualitzar la seva informació detallada.</p>
                <div id="emp-content">
                    <?php
                    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Models/employeesCRUD.php";

                    $emplyeesCRUD = new EmployeeCRUD();
                    // Paràmetres de paginació
                    $limit = 100;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Obtenir el total d'empleats per calcular el nombre de pàgines
                    $totalRows = $emplyeesCRUD->getTotalEmployeesCount();
                    $totalPages = ceil($totalRows / $limit);

                    // Obtenir empleats paginats
                    $employees = $emplyeesCRUD->getEmployeesPaginated($limit, $offset);

                    foreach ($employees as $employee) {
                        $deptObj = $emplyeesCRUD->getEmployeeDepartment($employee->getEmpNo());
                        $titleObj = $emplyeesCRUD->getEmployeeTitle($employee->getEmpNo());
                        $salaryObj = $emplyeesCRUD->getEmployeeSalaryObject($employee->getEmpNo());

                        echo "<div class='employee-card'>
                        <h3>" . htmlspecialchars($employee->getLastName() . ', ' . $employee->getFirstName()) . "</h3>
                        <p><strong>Departament:</strong> " . ($deptObj ? htmlspecialchars($deptObj->getDeptName()) : '-') . "</p>
                        <p><strong>Càrrec:</strong> " . ($titleObj ? htmlspecialchars($titleObj->getTitle()) : '-') . "</p>
                        <p><strong>Salari:</strong> " . ($salaryObj ? number_format($salaryObj->getSalary(), 0, ',', '.') : '-') . " €</p>
                        <div class='employee-actions'>
                        <a href='" . $baseUrl . "Views/employee.php?action=view&emp_no=" . urlencode($employee->getEmpNo()) . "' class='view-btn'><img src='" . $baseUrl . "Assets/icons/find.svg' alt='Veure'></a>
                        <a href='" . $baseUrl . "Views/employee.php?action=edit&emp_no=" . urlencode($employee->getEmpNo()) . "' class='edit-btn'><img src='" . $baseUrl . "Assets/icons/edit.svg' alt='Editar'></a>
                        <a href='" . $baseUrl . "Views/employee.php?action=delete&emp_no=" . urlencode($employee->getEmpNo()) . "' class='delete-btn'><img src='" . $baseUrl . "Assets/icons/remove.svg' alt='Eliminar'></a>
                        </div>
                        </div>";
                    }
                    ?>
                </div>
                <div id="emp-pagination">
                    <ul>
                        <?php if ($page > 1): ?>
                            <li><a href="?page=<?php echo $page - 1; ?>">&laquo; Anterior</a></li>
                        <?php endif; ?>

                        <?php
                        // Calcular el rang de pàgines a mostrar
                        $start = max(1, $page - 5);
                        $end = min($totalPages, $page + 5);
                        if ($end - $start < 9) {
                            if ($start == 1) {
                                $end = min($totalPages, $start + 9);
                            } elseif ($end == $totalPages) {
                                $start = max(1, $end - 9);
                            }
                        }
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li<?php if ($i == $page) echo ' class="active"'; ?>>
                                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li><a href="?page=<?php echo $page + 1; ?>">Següent &raquo;</a></li>
                            <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div id="emp-layout-right"></div>
        </div>


    </main>

    <?php
    // Incloem el footer per mostrar la informació legal i de contacte
    include $_SERVER['DOCUMENT_ROOT'] . $baseUrl . "Views/footer.php";
    ?>

</body>

</html>