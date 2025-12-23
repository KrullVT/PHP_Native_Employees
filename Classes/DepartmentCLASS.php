<?php

class DepartmentCLASS
{
    private $dept_no;
    private $dept_name;

    public function __construct($dept_no, $dept_name)
    {
        $this->dept_no = $dept_no;
        $this->dept_name = $dept_name;
    }

    public function getDeptNo()
    {
        return $this->dept_no;
    }

    public function getDeptName()
    {
        return $this->dept_name;
    }

    public function setDeptName($dept_name)
    {
        $this->dept_name = $dept_name;
    }

    public function setDeptNo($dept_no)
    {
        $this->dept_no = $dept_no;
    }

    public function __toString()
    {
        return "Department Number: " . $this->dept_no . ", Department Name: " . $this->dept_name;
    }
}
