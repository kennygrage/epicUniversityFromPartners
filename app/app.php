<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll(), 'students' => Student::getAll()));
    });

    $app->get("/students", function() use ($app) {
      return $app['twig']->render('students.html.twig', array('students' => Student::getAll(), 'courses' => Course::getAll()));
    });

    $app->get("/courses", function() use ($app) {
      return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/courses", function() use ($app) {
      $course = new Course($_POST['course_name'], $_POST['crn']);
      $course->save();
      return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/courses/{id}", function($id) use ($app) {
      $course = Course::find($id);
      return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->post("/courses/{id}/edit", function($id) use($app) {
        $course = Course::find($id);
        $course->update($_POST['course_name']);
        $course->updateCRN($_POST['crn']);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->get("/courses/{id}/delete", function($id) use($app) {
        $course = Course::find($id);
        $course->deleteOne();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/students", function () use ($app) {
      $id = null;
      $student = new Student($_POST['student_name'], $_POST['enroll_date'], $id);
      $student->save();
      return $app['twig']->render('students.html.twig', array('students' => Student::getAll(), 'courses' => Course::getAll()));
    });

    $app->get("/students/{id}", function ($id) use ($app) {
      $student = Student::find($id);
      return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->post("/students/{id}/edit", function ($id) use ($app) {
        $student = Student::find($id);
        $student->update($_POST['student_name']);
        $student->updateEnroll($_POST['enroll_date']);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->get("/students/{id}/delete", function($id) use($app) {
        $student = Student::find($id);
        $student->deleteOne();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/delete_students", function() use ($app) {
      Student::deleteAll();
      return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_courses", function() use ($app) {
      Course::deleteAll();
      return $app['twig']->render('index.html.twig');
    });
    
$app->post("/add_students", function () use ($app){
 $course = Course::find($_POST['course_id']);
 $student = Student::find($_POST['student_id']);
 $course->addStudent($student);
 return $app['twig']->render('course.html.twig', array('course'=>$course, 'courses' => Course::getAll(), 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
});
$app->post("/add_courses", function () use ($app){
 $course = Course::find($_POST['course_id']);
 $student = Student::find($_POST['student_id']);
 $student->addCourse($course);
 return $app['twig']->render('student.html.twig', array('student' => $student, 'students' => Student::getAll(), 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
});
    return $app;
?>
