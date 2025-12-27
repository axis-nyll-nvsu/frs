<?php
/*
 * Connection
 * Description: Returns a PHP Database Object
 * Author: Vernyll Jan P. Asis
 * Modified: 03-08-2025
 */

require '../vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file from the parent folder
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class Connection {
    private $dbHost;
    private $dbUser;
    private $dbPass;
    private $dbName;

    public function __construct() {
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPass = $_ENV['DB_PASS'];
        $this->dbName = $_ENV['DB_NAME'];
    }

    public function getConnection() {
        try {
            $pdo = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
        catch (Exception $e) {
            echo 'Error: ' . $e->getmessage();
        }
    }
}