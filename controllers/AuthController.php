<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
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

    public function logout(Request $request, Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile(){
        return $this->render('profile');
    }
}