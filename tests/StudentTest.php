<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Linking class for testing
    require_once "src/Student.php";
    require_once "src/Course.php";

    //Setting server up to apache and mysql passwords.
    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase {

        //Clears data for next test after each test
        protected function tearDown() {
            Student::deleteAll();
            Course::deleteAll();
        }

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

        function testSetStudentName() {
            //Arrange
            $student_name = "Paco";
            $id = 1;
            $enroll_date = "2012-10-20";
            $test_student = new Student($student_name, $id, $enroll_date);

            //Act
            $test_student->setStudentName("Pablo");
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals("Pablo", $result);
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
        function test_addCourse(){
            //Arrange
            $course_name = "MTH101";
            $crn = 1234;
            $id = 1;
            $test_course = new Course($course_name, $crn, $id);
            $test_course->save();

            $student_name = "Bob";
            $enroll_date = "2012-10-20";
            $id2 = 2;
            $test_student = new Student($student_name, $enroll_date, $id2);
            $test_student->save();

            //Act
            $test_student->addCourse($test_course);
            $result = $test_student->getCourses();

            //Assert
            $this->assertEquals([$test_course], $result);
        }
















        function testUpdate() {
             //Arrange
             $student_name = "Paco";
             $id = 1;
             $enroll_date = "2015-08-29";
             $test_student = new Student($student_name, $enroll_date, $id);
             $test_student->save();
             $new_student_name = "Pablo";

             //Act
             $test_student->update($new_student_name);

             //Assert
             $this->assertEquals("Pablo", $test_student->getStudentName());
         }

         function testDeleteStudent() {
             //Arrange
             $student_name = "Paco";
             $id = 1;
             $enroll_date = "2015-08-29";
             $test_student = new Student($student_name, $enroll_date, $id);
             $test_student->save();

             $student_name2 = "Pablo";
             $id2 = 2;
             $enroll_date2 = "2015-08-30";
             $test_student2 = new Student($student_name2, $enroll_date2, $id2);
             $test_student2->save();

             //Act
             $test_student->deleteOne();

             //Assert
             $this->assertEquals([$test_student2], Student::getAll());
         }

         function testAddCourse() {
             //Arrange
             $course_name = "History";
             $id = 1;
             $crn = "HIST101";
             $test_course = new Course($course_name, $crn, $id);
             $test_course->save();

             $student_name = "Paco";
             $id2 = 2;
             $enroll_date = "2015-03-22";
             $test_student = new Student($student_name, $enroll_date, $id2);
             $test_student->save();

             //Act
             $test_student->addCourse($test_course);
             $result = $test_student->getCourses();

             //Assert
             $this->assertEquals([$test_course], $result);
         }
         function testGetCourse() {
             //Arrange
             $course_name = "History";
             $id = 1;
             $crn = "HIST101";
             $test_course = new Course($course_name, $crn, $id);
             $test_course->save();

             $course_name2 = "Economics";
             $id2 = 2;
             $crn = "ECON101";
             $test_course2 = new Course($course_name2, $crn, $id2);
             $test_course2->save();

             $student_name = "Paco";
             $id3 = 3;
             $enroll_date = "2015-06-22";
             $test_student = new Student($student_name, $enroll_date, $id3);
             $test_student->save();

             //Act
             $test_student->addCourse($test_course);
             $test_student->addCourse($test_course2);

             //Assert
             $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
         }

         function testDelete() {
             //Arrange
             $course_name = "History";
             $id = 1;
             $crn = "HIST101";
             $test_course = new Course($course_name, $crn, $id);
             $test_course->save();

             $student_name = "Paco";
             $id2 = 2;
             $enroll_date = "2015-05-11";
             $test_student = new Student($student_name, $enroll_date, $id2);
             $test_student->save();

             //Act
             $test_student->addCourse($test_course);
             $test_student->deleteOne();

             //Assert
             $this->assertEquals([], $test_course->getStudents());
         }
     //Finished all student tests

    }
?>
