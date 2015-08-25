<?php


class Student {

    private $student_name;
    private $enroll_date;
    private $id;


    function __construct($student_name, $enroll_date, $id = null) {
        $this->student_name = $student_name;
        $this->enroll_date = $enroll_date;
        $this->id = $id;
    }

    function setStudentName($new_student_name){
        $this->student_name = $new_student_name;
    }

    function getStudentName(){
        return $this->student_name;
    }

    function getEnrollDate(){
        return $this->enroll_date;
    }

    function getId(){
        return $this->id;
    }

    function save() {
        $statement = $GLOBALS['DB']->exec("INSERT INTO students (student_name, enroll_date)
                        VALUES ('{$this->getStudentName()}', '{$this->getEnrollDate()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM students;");
    }

    static function getAll(){
        $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
        $students = array();
        foreach ($returned_students as $student) {
            $student_name = $student['student_name'];
            $enroll_date = $student['enroll_date'];
            $id = $student['id'];
            $new_student = new Student ($student_name, $enroll_date, $id);
            array_push($students, $new_student);
        }
        return $students;
    }



}

?>
