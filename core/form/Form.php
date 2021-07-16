<?php


namespace app\core\form;


use app\core\Model;

class Form
{

    public static function begin($action, $method, $class=''){
        echo sprintf('<form action="%s" method="%s" class="%s">', $action, $method, $class);
        return new Form();
    }

    public static function end(){
        echo '</form>';
    }

    public function field(Model $model, $attribute){
        return new InputField($model, $attribute);
    }
}