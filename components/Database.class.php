<?php

class Database
{
    protected PDO $pdo;
    public function __construct()
    {
        // Get config.json
        try {
            $config = (array) json_decode(file_get_contents("../config.json"))[0];
        } catch (Exception $e) {
            echo "Please check your config.json";
            exit();
        }
        // Check configuration
        // Check if host is empty
        if (empty($config['host'])) {
            echo "No host specified, make sure you setup a host in config.json. example: localhost";
            exit();
        }

        // Check if username is empty
        if (empty($config['username'])) {
            echo "No username specified. Make sure you setup a username in config.json";
            exit();
        }

        try {
            $this->pdo = new PDO("mysql:host={$config['host']};dbname=teddycloud;", $config['username'], $config['password']);
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function selectAllFromTable(string $table): array
    {
        // Add quotes
        $sanitizedtable = "`" . $table . "`";
        $query = "SELECT * FROM $sanitizedtable";
        $stmt = $this->pdo->query($query);

        // Return query as assosiative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectSomeFromTable(string|array $columns, string $table): array
    {
        // Add quotes
        $sanitizedtable = "`" . $table . "`";
        if (array($columns)) {
            $sanitizedcolumn = "";
            foreach ($columns as $column) {
                $sanitizedcolumn .= "`" . $column . "`";
            }
        } else {
            $sanitizedcolumn = "`" . $columns . "`";
        }
        $query = "SELECT $sanitizedcolumn FROM $sanitizedtable";
        $stmt = $this->pdo->query($query);

        // Return query as assosiative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Check if user exists
    protected function userExists(string $email): bool
    {
        $query = "SELECT email FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["email" => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If data is found return false
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }
}
?>