<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_Native_Employees/Classes/DepartmentCLASS.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/PHP_Native_Employees/Classes/ConnectionCLASS.php';

class DepartmentCRUD
{
    private $conn;

    public function __construct()
    {
        $database = new ConnectionCLASS();
        $this->conn = $database->getConnection();
    }

    public function __destruct()
    {
        $this->conn = null;
    }


    public function getAllDepartments()
    {
        $departments = [];
        $stmt = $this->conn->prepare("SELECT * FROM departments");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $department = new DepartmentCLASS($row['dept_no'], $row['dept_name']);
            $departments[] = $department;
        }

        return $departments;
    }

    public function getDepartmentByNo($deptNo)
    {
        $stmt = $this->conn->prepare("SELECT * FROM departments WHERE dept_no = ?");
        $stmt->bind_param("s", $deptNo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new DepartmentCLASS($row['dept_no'], $row['dept_name']);
        } else {
            return null;
        }
    }

    public function addDepartment($department)
    {
        $stmt = $this->conn->prepare("INSERT INTO departments (dept_no, dept_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $department->getDeptNo(), $department->getDeptName());
        return $stmt->execute();
    }

    public function updateDepartment($department)
    {
        $stmt = $this->conn->prepare("UPDATE departments SET dept_name = ? WHERE dept_no = ?");
        $stmt->bind_param("ss", $department->getDeptName(), $department->getDeptNo());
        return $stmt->execute();
    }

    public function deleteDepartment($deptNo)
    {
        $stmt = $this->conn->prepare("DELETE FROM departments WHERE dept_no = ?");
        $stmt->bind_param("s", $deptNo);
        return $stmt->execute();
    }

    public function getDepartmentsCount()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM departments");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['count'];
        } else {
            return 0;
        }
    }
}
