<?php

class Signup extends Database
{
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected string $confirmpassword;

    public function __construct(string $firstname, string $lastname, string $email, string $password, string $confirmpassword)
{
    parent::__construct();
    unset($_SESSION['errorssignup']);
    unset($_SESSION['errorslogin']);
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->password = $password;
    $this->confirmpassword = $confirmpassword;

    // Check for any empty input
    $_SESSION['firstname'] = $this->firstname;
    $_SESSION['lastname'] = $this->lastname;
    $_SESSION['email'] = $this->email;

    $errormessages = [];

    if (!$this->emptyInput()) {
        array_push($errormessages, "You did not fill in all information");
    }
    if (!$this->invalidEmail()) {
        array_push($errormessages, "Email is invalid");
    }
    if (!$this->userExists($this->email)) {
        array_push($errormessages, "Email already exists");
    }
    if (!$this->passwordRequirement()) {
        array_push($errormessages, "Your password must be at least 8 characters long");
    }
    if (!$this->confirmPassword()) {
        array_push($errormessages, "Your password does not match");
    }

    if (!empty($errormessages)) {
        $_SESSION['errors'] = $errormessages;
        header("location:" . $_SERVER['REQUEST_URI'] . "signup");
        exit();
    } else {
        $this->encryptPassword();
        $this->insertUser();
        header("location: ./logout");
        exit();
    }
}


    private function emptyInput(): bool
    {
        if (empty($this->firstname) || empty($this->lastname) || empty($this->email) || empty($this->password) || empty($this->confirmpassword)) {
            return false;
        } else {
            return true;
        }
    }
    private function passwordRequirement(): bool
    {
        if (strlen($this->password) < 8) {
            return false;
        } else {
            return true;
        }
    }
    private function encryptPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    private function confirmPassword(): bool
    {
        // Check if password confirmation matches
        if ($this->password == $this->confirmpassword) {
            return true;
        } else {
            return false;
        }
    }
    private function insertUser()
    {
        // Add user to database
        $query = "INSERT INTO users(firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "password" => $this->password
        ]);
        header("location: /logout");
        exit();
    }
    protected function invalidEmail(): bool
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }
}
