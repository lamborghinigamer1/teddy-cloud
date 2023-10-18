<?php

class Login extends Database
{
    protected string $email;
    protected string $password;

    public function __construct(string $email, string $password)
    {
        parent::__construct();
        unset($_SESSION['errorslogin']);
        unset($_SESSION['errorssignup']);
        $this->email = $email;
        $this->password = $password;
        $_SESSION['email'] = $this->email;

        $errormessages = [];
        if (!$this->emptyInput()) {
            array_push($errormessages, "You didn't fill in email or password");
        }
        if (!$this->verifyUser()) {
            array_push($errormessages, "Incorrect email or password");
        }
        if (!empty($errormessages)) {
            foreach ($errormessages as $error) {
                echo "<p>" . $error . "</p>";
            }
        } else {
            unset($_SESSION['email']);
            header("location: ./");
        }
    }
    private function emptyInput(): bool
    {
        if (empty($this->email) || empty($this->password)) {
            return false;
        } else {
            return true;
        }
    }
    private function verifyUser(): bool
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["email" => $this->email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            if (!$this->verifyUserPassword($result['password'])) {
                return false;
            } else {
                $_SESSION['firstname'] = $result['firstname'];
                $_SESSION['userid'] = $result['id'];
                return true;
            }
        } else {
            return false;
        }
    }
    private function verifyUserPassword(string $databasePasswordHash): bool
    {
        if (password_verify($this->password, $databasePasswordHash)) {
            return true;
        } else {
            return false;
        }
    }
}
