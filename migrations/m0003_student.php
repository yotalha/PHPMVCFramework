<?php

class m0003_student{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE students (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(225) NOT NULL,
                section VARCHAR(225) NOT NULL,
                department VARCHAR(225) NOT NULL,
                firstname VARCHAR(255) NOT NULL,
                lastname VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                status TINYINT NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE students;";
        $db->pdo->exec($SQL);
    }
}
