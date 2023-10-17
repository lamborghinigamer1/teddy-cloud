<?php

class Login extends Database
{
    protected string $email;
    protected string $password;
    
    public function __construct(string $email, string $password, Database $pdo)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->pdo = $pdo;
        $this->verifyLogin();
    }
    private function emptyInput(): bool
    {
        if (empty($this->email) || empty($this->password)) {
            return false;
        } else {
            return true;
        }
    }
    private function verifyLogin(): bool
    {
        return true;
    }
}

?>