<?php
// Model CRUD per a la gestió d'empleats utilitzant connectionCLASS i employeeCLASS
require_once __DIR__ . '/../Classes/ConnectionCLASS.php';
require_once __DIR__ . '/../Classes/EmployeeCLASS.php';

class EmployeeCRUD
{
    public $conn;

    public function __construct()
    {
        $db = new ConnectionCLASS();
        $this->conn = $db->getConnection();
    }

    // Obtenir tots els empleats (limitat a 100 per seguretat)
    public function getAllEmployees()
    {
        $sql = "SELECT * FROM employees LIMIT 100";
        $result = $this->conn->query($sql);
        $employees = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = new EmployeeCLASS(
                    $row['emp_no'],
                    $row['birth_date'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['gender'],
                    $row['hire_date']
                );
            }
        }
        return $employees;
    }

    // Obtenir empleats paginats
    public function getEmployeesPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM employees LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $employees = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = new EmployeeCLASS(
                    $row['emp_no'],
                    $row['birth_date'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['gender'],
                    $row['hire_date']
                );
            }
        }
        return $employees;
    }

    // Obtenir el total d'empleats per a la paginació
    public function getTotalEmployeesCount()
    {
        $sql = "SELECT COUNT(*) as total FROM employees";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    // Obtenir un empleat per ID
    public function getEmployeeById($emp_no)
    {
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE emp_no = ?");
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            return new EmployeeCLASS(
                $row['emp_no'],
                $row['birth_date'],
                $row['first_name'],
                $row['last_name'],
                $row['gender'],
                $row['hire_date']
            );
        }
        return null;
    }

    // Crear un nou empleat
    public function createEmployee($birth_date, $first_name, $last_name, $gender, $hire_date)
    {
        $stmt = $this->conn->prepare("INSERT INTO employees (birth_date, first_name, last_name, gender, hire_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $birth_date, $first_name, $last_name, $gender, $hire_date);
        return $stmt->execute();
    }

    // Actualitzar un empleat
    public function updateEmployee($emp_no, $birth_date, $first_name, $last_name, $gender, $hire_date)
    {
        $stmt = $this->conn->prepare("UPDATE employees SET birth_date = ?, first_name = ?, last_name = ?, gender = ?, hire_date = ? WHERE emp_no = ?");
        $stmt->bind_param('sssssi', $birth_date, $first_name, $last_name, $gender, $hire_date, $emp_no);
        return $stmt->execute();
    }

    // Eliminar un empleat
    public function deleteEmployee($emp_no)
    {
        $stmt = $this->conn->prepare("DELETE FROM employees WHERE emp_no = ?");
        $stmt->bind_param('i', $emp_no);
        return $stmt->execute();
    }

    // Obtenir el departament i el càrrec (title) d'un empleat
    public function getEmployeeDepartmentAndTitle($emp_no)
    {
        $sql = "SELECT d.dept_name, t.title FROM employees e
                JOIN dept_emp de ON e.emp_no = de.emp_no
                JOIN departments d ON de.dept_no = d.dept_no
                JOIN titles t ON e.emp_no = t.emp_no
                WHERE e.emp_no = ?
                ORDER BY t.to_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            return [
                'department' => $row['dept_name'],
                'title' => $row['title']
            ];
        }
        return null;
    }

    // Obtenir el salari actual d'un empleat
    public function getEmployeeSalary($emp_no)
    {
        $sql = "SELECT salary FROM salaries WHERE emp_no = ? ORDER BY to_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            return $row['salary'];
        }
        return null;
    }

    // Obtenir el departament d'un empleat com a objecte departmentCLASS
    public function getEmployeeDepartment($emp_no)
    {
        $sql = "SELECT d.dept_no, d.dept_name FROM employees e
                JOIN dept_emp de ON e.emp_no = de.emp_no
                JOIN departments d ON de.dept_no = d.dept_no
                WHERE e.emp_no = ? ORDER BY de.to_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            require_once __DIR__ . '/../Classes/DepartmentCLASS.php';
            return new DepartmentCLASS($row['dept_no'], $row['dept_name']);
        }
        return null;
    }

    // Obtenir el títol d'un empleat com a objecte titleCLASS
    public function getEmployeeTitle($emp_no)
    {
        $sql = "SELECT emp_no, title, from_date, to_date FROM titles WHERE emp_no = ? ORDER BY to_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            require_once __DIR__ . '/../Classes/TitleCLASS.php';
            return new TitleCLASS($row['emp_no'], $row['title'], $row['from_date'], $row['to_date']);
        }
        return null;
    }

    // Obtenir el salari d'un empleat com a objecte salaryCLASS
    public function getEmployeeSalaryObject($emp_no)
    {
        $sql = "SELECT emp_no, salary, from_date, to_date FROM salaries WHERE emp_no = ? ORDER BY to_date DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $emp_no);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            require_once __DIR__ . '/../Classes/SalaryCLASS.php';
            return new SalaryCLASS($row['emp_no'], $row['salary'], $row['from_date'], $row['to_date']);
        }
        return null;
    }

    // Tancar la connexió a la base de dades quan l'objecte és destruït
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
