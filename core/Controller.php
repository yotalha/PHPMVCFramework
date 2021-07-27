<?php


namespace app\core;



use app\core\middlewares\BaseMiddleware;

class Controller
{
    public $layout = 'main';
    public $action = '';
    /**
     * @var BaseMiddleware[]
     */
    protected $middlewares = [];

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []){
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;
    }

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

}