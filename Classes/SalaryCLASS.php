<?php

class SalaryCLASS
{
    private $emp_no;
    private $salary;
    private $from_date;
    private $to_date;

    public function __construct($emp_no, $salary, $from_date, $to_date)
    {
        $this->emp_no = $emp_no;
        $this->salary = $salary;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getEmpNo()
    {
        return $this->emp_no;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getFromDate()
    {
        return $this->from_date;
    }

    public function getToDate()
    {
        return $this->to_date;
    }

    public function setEmpNo($emp_no)
    {
        $this->emp_no = $emp_no;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setFromDate($from_date)
    {
        $this->from_date = $from_date;
    }

    public function setToDate($to_date)
    {
        $this->to_date = $to_date;
    }
}
