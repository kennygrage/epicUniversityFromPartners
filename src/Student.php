<?php

//Currently working out JOIN statements for the getCourses method.

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

    //Add a course to a student:
    function addCourse($course){
        $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id)
                    VALUES ({$course->getId()}, {$this->getId()});");
    }

    //Get all courses assigned to a student:
    //This method is UNFINISHED.
    function getCourses() {
        //join statement
        $found_courses = $GLOBALS['DB']->query("SELECT courses.* FROM
        students JOIN students_courses ON (students.id = students_courses.student_id)
                 JOIN courses ON (students_courses.course_id = courses.id)
                 WHERE (students.id = {$this->getId()});");
         //convert output of the join statement into an array
         $found_courses = $found_courses->fetchAll(PDO::FETCH_ASSOC);
         $student_courses = array();
         foreach($found_courses as $found_course) {
             $course_name = $found_course['course_name'];
             $id = $found_course['id'];
             $crn = $found_course['crn'];
             $new_course = new Course($course_name, $crn, $id);
             array_push($student_courses, $new_course);
         }
         return $student_courses;
    }

    //Save a student to students table:
    function save() {
        $statement = $GLOBALS['DB']->exec("INSERT INTO students (student_name, enroll_date)
                        VALUES ('{$this->getStudentName()}', '{$this->getEnrollDate()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    //change student name
    function update($new_student_name) {
        $GLOBALS['DB']->exec("UPDATE students SET student_name = '{$new_student_name}' WHERE id = {$this->getId()};");
        $this->setStudentName($new_student_name);
    }

    function updateEnroll($new_enroll_date) {
        $GLOBALS['DB']->exec("UPDATE students set enroll_date = '{$new_enroll_date}' WHERE id = {$this->getId()};");
    }

    //delete one student
    function deleteOne() {
        $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getId()};");
    }

    //Clear all students from students table:
    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM students;");
    }

    //Retrieve all students from students table:
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

    //Find students by id in students table:
    //Built finder with DB query string instead of foreach loop.  It works :P
    static function find($search_id){
        $search_student = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$search_id}");
        $found_student = $search_student->fetchAll(PDO::FETCH_ASSOC);
        $student_name = $found_student[0]['student_name'];
        $enroll_date = $found_student[0]['enroll_date'];
        $id = $found_student[0]['id'];
        $new_student = new Student($student_name, $enroll_date, $id);
        return $new_student;
    }



}

?>
