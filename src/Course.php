<?php

class Course {

    private $course_name;
    private $crn;
    private $id;

    function __construct($course_name, $crn, $id = null) {
        $this->course_name = $course_name;
        $this->crn = $crn;
        $this->id = $id;
    }

    function setCourseName($new_course_name) {
        $this->course_name = $new_course_name;
    }

    function getCourseName(){
        return $this->course_name;
    }

    function getCRN() {
        return $this->crn;
    }

    function getId() {
        return $this->id;
    }

    //Save a course to courses table:
    function save() {
        $statement = $GLOBALS['DB']->exec("INSERT INTO courses (course_name, crn)
                VALUES ('{$this->getCourseName()}', '{$this->getCRN()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    //Clear all courses from courses table:
    static function deleteAll() {
        $GLOBALS['DB']->exec("DELETE FROM courses;");
    }

    //Retrieve all courses from courses table:
    static function getAll() {
        $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
        $courses = array();
        foreach ($returned_courses as $course) {
            $course_name = $course['course_name'];
            $crn = $course['crn'];
            $id = $course['id'];
            $new_course = new Course($course_name, $crn, $id);
            array_push($courses, $new_course);
        }
        return $courses;
    }

    //Find courses by id in courses table:
    //Built finder with DB query string instead of foreach loop. It works :P
    static function find($search_id) {
        $search_course = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$search_id}");
        $found_course = $search_course->fetchAll(PDO::FETCH_ASSOC);
        $course_name = $found_course[0]['course_name'];
        $crn = $found_course[0]['crn'];
        $id = $found_course[0]['id'];
        $new_student = new Course($course_name, $crn, $id);
        return $new_student;
    }
}


?>
