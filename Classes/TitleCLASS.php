<?php

class TitleCLASS
{
    private $emp_no;
    private $title;
    private $from_date;
    private $to_date;

    public function __construct($emp_no, $title, $from_date, $to_date)
    {
        $this->emp_no = $emp_no;
        $this->title = $title;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getEmpNo()
    {
        return $this->emp_no;
    }

    public function getTitle()
    {
        return $this->title;
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

    public function setTitle($title)
    {
        $this->title = $title;
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
