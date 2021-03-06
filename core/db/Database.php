<?php


namespace app\core\db;


use app\core\Application;

class Database
{
    /** @var \PDO  */
    public $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
       $servername = "localhost";
        $username = "root";
        $password = "root";

        try {
            $this->pdo = new \PDO("mysql:host=$servername;dbname=myDB", $username, $password);
            // set the PDO error mode to exception
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function applyMigrations(){
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration){
            if($migration === '.' || $migration === '..'){
                continue;
            }

            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }
        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            $this->log("All migrations are applied");
        }
    }

    public function createMigrationsTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations(){
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations){
        $newArr = [];
        foreach ($migrations as $m){
            $newArr = "('$m')";
        }
        var_dump($newArr);
        $str = implode(",", $newArr);
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str        
            ");
        $statement->execute();
    }

    public function prepare($sql){
        return $this->pdo->prepare($sql);
    }

    protected function log($message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
}
