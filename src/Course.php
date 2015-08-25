<?php

    require_once "Student.php";

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

        function setCRN($new_crn) {
            $this->crn = $new_crn;
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

        function getStudents() {
            $query = $GLOBALS['DB']->query("SELECT student_id FROM students_courses WHERE course_id = {$this->getId()};");
            $student_ids = $query->fetchAll(PDO::FETCH_ASSOC);
            $students = Array();
            foreach($student_ids as $id) {
                $student_id = $id['student_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$student_id};");
                $returned_student = $result->fetchAll(PDO::FETCH_ASSOC);
                $student_name = $returned_student[0]['student_name'];
                $id = $returned_student[0]['id'];
                $enroll_date = $returned_student[0]['enroll_date'];
                $new_student = new Student($student_name, $enroll_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        function update($new_course_name) {
            $GLOBALS['DB']->exec("UPDATE courses set course_name = '{$new_course_name}' WHERE id = {$this->getId()};");
            $this->setCourseName($new_course_name);
        }

        function updateCRN($new_crn) {
            $GLOBALS['DB']->exec("UPDATE courses set crn = '{$new_crn}' WHERE id = {$this->getId()};");
        }

        function addStudent($student) {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE course_id = {$this->getId()};");
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
