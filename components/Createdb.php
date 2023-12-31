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

// If dbtrue.txt doesn't exist create database
if (!file_exists("../dbtrue.txt")) {
    try {
        // Try to connect to database
        $pdo = new PDO("mysql:host={$config['host']};", $config['username'], $config['password']);

        // Remove upload folder for debugging purposes
        rmdir("uploads");
        // Drop database for debugging purposes
        $pdo->exec("DROP DATABASE IF EXISTS teddycloud;");

        mkdir("uploads");

        // Create database if doesn't exist
        $pdo->exec(
            "CREATE DATABASE teddycloud;
            

        USE teddycloud;

        CREATE TABLE users(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );

        CREATE TABLE files(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            userid int NOT NULL,
            trash BOOLEAN NOT NULL,
            filename varchar(255) NOT NULL,
            filesize INT NOT NULL,
            filelocation varchar(255) NOT NULL,
            filetype varchar(255) NOT NULL,
            FOREIGN KEY (userid) REFERENCES users(id)
        );
        
        CREATE TABLE themes(
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
    } finally {
        $createfile = fopen("../dbtrue.txt", "w");
        if ($createfile) {
            fwrite($createfile, "Database created successfully. Please delete this file to reinitialize the database creation");
            fclose($createfile);
        }
        header("location: ./");
    }
}
