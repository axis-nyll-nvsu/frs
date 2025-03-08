<?php
/*
 * PDO Connection
 * Description: Returns a PHP Database Object
 * Author: 
 * Modified: 11-23-2024
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
	private $dbUser;
	private $pdo;

    public function __construct() {
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPass = $_ENV['DB_PASS'];
        $this->dbName = $_ENV['DB_NAME'];
    }

	public function conn() {
		try {
			$this->pdo = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, $this->dbUser, $this->dbPass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $this->pdo;			
		}
		catch (Exception $e) {
			echo 'Error: ' . $e->getmessage();
		}
	}
}