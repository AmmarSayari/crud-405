<?php

require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


class Database {
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;

    

    public function __construct()
    {
        // read database credentials as environment variables
        // $this->dbHost = getenv('DB_HOST');
        // $this->dbPort = getenv('DB_PORT');
        // $this->dbName = getenv('DB_DATABASE');
        // $this->dbUser = getenv('DB_USERNAME');
        // $this->dbPassword = getenv('DB_PASSWORD');
        $this->dbHost = $_ENV['DB_HOST'] ?? null;
        $this->dbPort = $_ENV['DB_PORT'] ?? null;
        $this->dbName = $_ENV['DB_DATABASE'] ?? null;
        $this->dbUser = $_ENV['DB_USERNAME'] ?? null;
        $this->dbPassword = $_ENV['DB_PASSWORD'] ?? null;

    if(!$this->dbHost || !$this->dbPort || !$this->dbName || !$this->dbUser || !$this->dbPassword) {
        die("Please set database credentials as environment variables.");
        }
    }

    public function connect(){
        try{
            $this->dbConnection = new PDO(
            'mysql: host='. $this->dbHost . ';port='.$this->dbPort. '; dbname='.$this->dbName, $this->dbUser, $this->dbPassword
            );
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        catch (PDOException $e) {
            die("Connection Error ". $e->getMessage());
        }
        return $this->dbConnection;

    }
}
