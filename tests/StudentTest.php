<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Student.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test
        protected function tearDown() {
            Student::deleteAll();
        }


        //Testing getters and setters
        // function test_setStudentName() {
        //     //Arrange
        //     $student_name = "Bob";
        //     $enroll_date = "2012-10-20";
        //     $id = 1;
        //     $test_student = new Student($student_name, $enroll_date, $id);
        //     $test_student->save();
        //
        //     //Act
        //     $new_name = "Sue";
        //     $result = $test_student->setStudentName($new_name);
        //
        //     //Assert
        //     $this->assertEquals($result, $new_name);
        // }

        //Test getters:
        function test_getStudentName() {

            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = 1;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            //Act
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals($result, $student_name);
        }

        function test_getEnrollDate() {

            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = 1;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            //Act
            $result = $test_student->getEnrollDate();

            //Assert
            $this->assertEquals($result, $enroll_date);
        }

        function test_getId() {
            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = null;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test save:
        function test_save() {
            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = null;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student], $result);
        }

        //Test getAll:
        function test_getAll() {
            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = null;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            $student_name2 = "Sue";
            $enroll_date2 = "2013-09-09";
            $test_student2 = new Student($student_name2, $enroll_date2, $id);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        //Test deleteAll:
        function test_deleteAll(){
            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = null;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            $student_name2 = "Sue";
            $enroll_date2 = "2013-09-09";
            $test_student2 = new Student($student_name2, $enroll_date2, $id);
            $test_student2->save();

            //Act
            Student::deleteAll();
            $result = Student::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //Test find:
        function test_find(){
            //Arrange
            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id = null;
            $test_student = new Student($student_name, $enroll_date, $id);
            $test_student->save();

            $student_name2 = "Sue";
            $enroll_date2 = "2013-09-09";
            $test_student2 = new Student($student_name2, $enroll_date2, $id);
            $test_student2->save();

            //Act
            $id = $test_student->getId();
            $result = Student::find($id);

            //Assert
            $this->assertEquals($test_student, $result);
        }

        //Test add course to student






    }






?>
