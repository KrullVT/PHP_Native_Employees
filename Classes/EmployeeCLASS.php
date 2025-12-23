<?php

class EmployeeCLASS
{
    private $emp_no;
    private $birth_date;
    private $first_name;
    private $last_name;
    private $gender;
    private $hire_date;

    public function __construct($emp_no, $birth_date, $first_name, $last_name, $gender, $hire_date)
    {
        $this->emp_no = $emp_no;
        $this->birth_date = $birth_date;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->hire_date = $hire_date;
    }

    public function getEmpNo()
    {
        return $this->emp_no;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getHireDate()
    {
        return $this->hire_date;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setHireDate($hire_date)
    {
        $this->hire_date = $hire_date;
    }

    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAge()
    {
        $birthDate = new DateTime($this->birth_date);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        return $age;
    }

    public function getYearsOfService()
    {
        $hireDate = new DateTime($this->hire_date);
        $today = new DateTime();
        $yearsOfService = $today->diff($hireDate)->y;
        return $yearsOfService;
    }

    public function toArray()
    {
        return [
            'emp_no' => $this->emp_no,
            'birth_date' => $this->birth_date,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'hire_date' => $this->hire_date,
        ];
    }
}
