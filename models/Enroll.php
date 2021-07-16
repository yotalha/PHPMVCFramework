<?php


namespace app\models;


use app\core\db\DbModel;
use app\core\Model;
use app\core\UserModel;
use PDO;

class Enroll extends DbModel
{
    public string $student_email = '';
    public string $course_id = '';

    public function tableName(): string
    {
        return 'enrolls';
    }

    public function findAll(){
        $tableName = self::tableName();
        $sth = self::prepare("select * from enrolls");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }


    public function primaryKey(): string
    {
        return 'id';
    }

    public function save(){
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'student_email' => [self::RULE_REQUIRED],
            'course_id' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class, 'scope' => ['student_email']
            ]],
        ];
    }

    public function attributes(): array
    {
        return ['student_email', 'course_id'];
    }

}