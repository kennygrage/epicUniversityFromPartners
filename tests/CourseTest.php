<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Course.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test:
        protected function tearDown() {
            Course::deleteAll();
        }

        //Test getters:
        function test_getCourseName() {

            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($result, $course_name);
        }

        function test_getCRN() {

            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            //Act
            $result = $test_course->getCRN();

            //Assert
            $this->assertEquals($result, $crn);
        }

        function test_getId() {

            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test save:
        function test_save() {
            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course], $result);
        }

        //Test getAll:
        function test_getAll() {
            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            $course_name2 = "HST202";
            $crn2 = 5678;
            $test_course2 = new Course($course_name2, $crn2, $id);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        //Test find:
        function test_find() {
            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = null;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            $course_name2 = "HST202";
            $crn2 = 5678;
            $test_course2 = new Course($course_name2, $crn2, $id);
            $test_course2->save();

            //Act
            $id = $test_course->getId();
            $result = Course::find($id);

            //Assert
            $this->assertEquals($test_course, $result);
        }


    }
?>
