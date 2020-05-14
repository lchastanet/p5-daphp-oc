<?php

namespace App\Model\Users;

use App\lib\Entity;

class User extends Entity
{
    const LOGIN_INVALIDE = 1;
    const EMAIL_INVALIDE = 2;
    const PASSWORD_INVALIDE = 3;
    protected $id;
    protected $login;
    protected $email;
    protected $password;
    protected $validated;
    protected $role;
    protected $validationToken;

    public function isValid()
    {
        return true;
    }

    // SETTERS //

    public function setLogin($login)
    {
        if (!is_string($login) || empty($login)) {
            $this->erreurs[] = self::LOGIN_INVALIDE;
        }

        $this->login = $login;
    }

    public function setId($id)
    {
        if (!is_string($id) || empty($id)) {
            $this->erreurs[] = self::LOGIN_INVALIDE;
        }

        $this->id = $id;
    }

    public function setEmail($email)
    {
        if (!is_string($email) || empty($email)) {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        }

        $this->email = $email;
    }

    public function setPassword($password)
    {
        if (!is_string($password) || empty($password)) {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }

        $this->password = $password;
    }

    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    public function setValidationToken($validationToken)
    {
        $this->validationToken = $validationToken;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    // GETTERS //

    public function id()
    {
        return $this->id;
    }

    public function login()
    {
        return $this->login;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function validated()
    {
        return $this->validated;
    }

    public function role()
    {
        return $this->role;
    }

    public function validationToken()
    {
        return $this->validationToken;
    }
}
