<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Course;
use app\models\Enroll;
use app\models\LoginForm;
use app\models\Student;
use app\models\Teacher;
use app\models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response){
        $loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());

            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function validateCourse(Request $request, Response $response)
    {
        $data = $request->getBody();
        $error = null;
        $user_email = $_SESSION['user'];
        if(!$user_email){
            $error->message = 'user not found';
            $response->setStatusCode(401);
            return $this->renderJson($error);
        }
        $teacher = Teacher::findOne(["email"=> $user_email]);
//        var_dump($teacher);
        $courses = Course::findAll();
        $start_time = strtotime($data['start']);
        $end_time = strtotime($data['end']);
        $conflict = false;
        foreach ($courses as $course){
            if ($start_time > strtotime($course['end']) || $end_time < strtotime($course['start'])) {
                $conflict = false;
            } else {
                $conflict = true;
                break;
            }
        }


//        var_dump($courses);
//        $response->setStatusCode(422);

        $response->setResponseHeader('Content-Type', 'application/json');
        if($conflict)
            return $this->renderJson(['message'=>'you have a conflict']);
        else
            return $this->renderJson(['message'=>'ok']);
    }



    public function register(Request $request){
        $errors = [];
        $user = new User();
        if($request->isPost()){

            $user->loadData($request->getBody());


            if($user->validate() && $user->save()){
                Application::$app->session->setFLash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                exit;
            }

            return $this->render('register', [
                'model' => $user
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function registerStudent(Request $request){
        $errors = [];
        $student = new Student();
        if($request->isPost()){

            $student->loadData($request->getBody());


            if($student->validate() && $student->save()){
                Application::$app->session->setFLash('success', 'Student registered successfully');
                Application::$app->response->redirect('/');
                exit;
            }

            return $this->render('registerStudent', [
                'model' => $student
            ]);
        }
        $this->setLayout('auth');
        return $this->render('registerStudent', [
            'model' => $student
        ]);
    }

    public function registerTeacher(Request $request){
        $errors = [];
        $teacher = new Teacher();
        if($request->isPost()){

            $teacher->loadData($request->getBody());


            if($teacher->validate() && $teacher->save()){
                Application::$app->session->setFLash('success', 'Teacher registered successfully');
                Application::$app->response->redirect('/');
                exit;
            }

            return $this->render('registerTeacher', [
                'model' => $teacher
            ]);
        }
        $this->setLayout('auth');
        return $this->render('registerTeacher', [
            'model' => $teacher
        ]);
    }


    public function teacherCourse(Request $request, Response $response){

        $errors = [];
        $course = new Course();
        if($request->isPost()){
            $course->loadData($request->getBody());
            if($course->validate() && $course->save()){
                Application::$app->session->setFLash('success', 'Course Added successfully');
//                Application::$app->response->redirect('/');
                return $this->renderJson("/");
                exit;
            }
            $response->setStatusCode(422);
            return $this->renderJson($course->errors);
        }
        $this->setLayout('auth');
        return $this->render('teacherCourse', [
            'model' => $course
        ]);
    }

    public function enroll(Request $request, Response $response){
        $errors = [];
        $course = new Course();

        $enroll = new Enroll();
        if($request->isPost()){

            $course_id = $_POST["course_id"];
            $student_email = $_SESSION['user'];

            $data = ['student_email' =>$student_email, 'course_id' => $course_id];

            $enroll->loadData($data);

            if($enroll->validate() && $enroll->save()){
                Application::$app->session->setFLash('success', 'Course Added successfully');
                return $this->renderJson("/studentCourse");
                return ;
            }
            $response->setStatusCode(422);
            return $this->renderJson($enroll->errors);
        }
    }

    public function studentCourse(Request $request){
        $errors = [];
        $course = new Course();
//        if($request->isPost()){
//
//            $course->loadData($request->getBody());
//
//
//            if($course->validate() && $course->save()){
//                Application::$app->session->setFLash('success', 'Course Added successfully');
//                Application::$app->response->redirect('/');
//                exit;
//            }
//
//            return $this->render('teacherCourse', [
//                'model' => $course
//            ]);
//        }
        $this->setLayout('main');
        return $this->render('studentCourse', [
            'model' => $course
        ]);
    }


    public function logout(Request $request, Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile(){
        return $this->render('profile');
    }




}