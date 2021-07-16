<?php

class m0006_enroll{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE enrolls (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_email VARCHAR(225) NOT NULL,
                course_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE enrolls;";
        $db->pdo->exec($SQL);
    }

}
