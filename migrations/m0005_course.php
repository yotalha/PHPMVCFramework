<?php

class m0005_course{
    public function up(){
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE courses (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(225) NOT NULL,
                start TIME NOT NULL,
                end TIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE courses;";
        $db->pdo->exec($SQL);
    }

}
