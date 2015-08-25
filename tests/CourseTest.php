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

        function testSetCourseName()
        {
            //Arrange
            $course_name = "History";
            $crn = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $crn, $id);

            //Act
            $test_course->setCourseName("Economics");
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("Economics", $result);
        }

        function testSetCRN()
        {
            //Arrange
            $course_name = "History";
            $crn = "HIST101";
            $id = 1;
            $test_course = new Course($course_name, $crn, $id);

            //Act
            $test_course->setCRN("ECON101");
            $result = $test_course->getCRN();

            //Assert
            $this->assertEquals("ECON101", $result);
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

        function testUpdate () {
            //Arrange
            $course_name = "History";
            $id = 1;
            $crn = "HIST101";
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            $new_course_name = "Economics";

            //Act
            $test_course->update($new_course_name);

            //Assert
            $this->assertEquals("Economics", $test_course->getCourseName());
        }

        function testDeleteCourse()
        {
            //Arrange
            $course_name = "Economics";
            $id = 1;
            $crn = "ECON101";
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            $course_name2 = "History";
            $id2 = 2;
            $crn2 = "HIST101";
            $test_course2 = new Course($course_name, $crn2, $id2);
            $test_course2->save();

            //Act
            $test_course->deleteOne();
            
            //Assert
            $this->assertEquals([$test_course2], Course::getAll());
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
