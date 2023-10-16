<?php

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

// Connect to database
try {
    // Try to connect to database
    $pdo = new PDO("mysql:host={$config['host']};", $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if doesn't exist
    $pdo->exec(
        "CREATE DATABASE IF NOT EXISTS teddycloud;

        USE teddycloud;

        CREATE TABLE IF NOT EXISTS users(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS files(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            userid int NOT NULL,
            trash BOOLEAN NOT NULL,
            filename varchar(255) NOT NULL,
            filesize INT NOT NULL,
            filelocation varchar(255) NOT NULL,
            FOREIGN KEY (userid) REFERENCES users(id)
        );
        
        CREATE TABLE IF NOT EXISTS themes(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            userid INT NOT NULL,
            name VARCHAR(255) NOT NULL UNIQUE,
            description TEXT NOT NULL,
            FOREIGN KEY (userid) REFERENCES users(id)
        );
        "
    );
    $pdo->exec("USE teddycloud;");
} catch (PDOException $e) {
    echo $e;
}
