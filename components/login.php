<?php

class Login
{
    protected string $username;
    protected string $password;
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}

?>