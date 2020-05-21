<?php

namespace App\Model\Users;

use App\lib\Entity;

class User extends Entity
{
    protected $login;
    protected $email;
    protected $password;
    protected $validated;
    protected $role;
    protected $validationToken;

    public function isValid()
    {
        return !(empty($this->login) ||
            empty($this->email) ||
            empty($this->password) ||
            empty($this->validated) ||
            empty($this->role) ||
            empty($this->validationToken));
    }

    // SETTERS //

    public function setLogin($login)
    {
        if (!is_string($login) || empty($login)) {
            $this->erreurs[] = "login invalide";
        }

        $this->login = $login;
    }

    public function setId($id)
    {
        if (!is_string($id) || empty($id)) {
            $this->erreurs[] = "id invalide";
        }

        $this->id = $id;
    }

    public function setEmail($email)
    {
        if (!is_string($email) || empty($email)) {
            $this->erreurs[] = "email invalide";
        }

        $this->email = $email;
    }

    public function setPassword($password)
    {
        if (!is_string($password) || empty($password)) {
            $this->erreurs[] = "mot de passe invalide";
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
