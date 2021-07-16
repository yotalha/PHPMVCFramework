<?php

namespace app\core;

use app\core\db\Database;
use app\models\Student;
use app\models\Teacher;
use app\models\User;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public ?UserModel $student;
    public View $view;

    public static Application $app;
    public ?Controller $controller = null;
    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database();

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = Student::primaryKey();
            $user = Student::findOne([$primaryKey => $primaryValue]) ?? null;
            if(!$user){
                $primaryKey = Teacher::primaryKey();
                $user = Teacher::findOne([$primaryKey => $primaryValue]) ?? null;
            }

            if ($user){
                $this->user = $user;
            }
        }
        else{
            $this->user = null;
        }

    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run(){
        try {
            echo $this->router->resolve();
        }catch (\Exception $e){
            $this->response->setStatusCode(is_numeric($e->getCode())? $e->getCode() : 500);
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function loginUser(UserModel $user){
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function login(UserModel $user){
//        $this->student = $student;
        $this->user = $user;
        $primaryKey = $user->primaryKey();

        $primaryValue = $user->{$primaryKey};

        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout(){
        $this->user = null;
        $this->session->remove('user');
    }


}