<?php


namespace app\models;


use app\core\db\DbModel;
use app\core\Model;
use app\core\UserModel;
use PDO;

class Course extends DbModel
{
    public string $name = '';
    public string $start = '';
    public string $end = '';

    public function tableName(): string
    {
        return 'courses';
    }

    public function findAll(){
        $tableName = self::tableName();
        $sth = self::prepare("select * from courses");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function primaryKey(): string
    {
        return 'name';
    }

    public function save(){
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'start' => [self::RULE_REQUIRED, [
                self::RULE_CUSTOM, 'function' => 'validate_conflict'
            ]],
            'end' => [self::RULE_REQUIRED],
        ];
    }

    public function validate_conflict(){
        $courses = self::findAll();
        $start_time = strtotime($this->start);
        $end_time = strtotime($this->end);
        $conflict = false;
        foreach ($courses as $item){
            if (($end_time < strtotime($item['start']) && $start_time < strtotime($item['start'])) || ($start_time > strtotime($item['end']) && $end_time > strtotime($item['end']))) {
                $conflict = false;
            } else {
                $conflict = true;
                break;
            }
        }
        if($conflict){
            $this->addError('start', 'you hav a conflict');
        }
    }

    public function attributes(): array
    {
        return ['name', 'start', 'end'];
    }

    public function labels(): array
    {
        return [
            'name' => 'Course Name',
            'start' => 'Start Time',
            'end' => 'End Time',
        ];
    }
}