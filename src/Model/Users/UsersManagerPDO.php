<?php

namespace App\Model\Users;

class UsersManagerPDO extends UsersManager
{
    public function getByEmail($email)
    {
        $q = $this->dao->prepare('SELECT id, login, email, validated, role, password FROM users WHERE email = :email');
        $q->bindValue(':email', (string) $email, \PDO::PARAM_STR);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Entity\User');

        if ($user = $q->fetch()) {
            return $user;
        }

        return null;
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    protected function add(User $user)
    {
        $q = $this->dao->prepare('INSERT INTO users SET login = :login, email = :email, password = :password, validated = :validated, role = :role, validationToken = :validationToken');

        $q->bindValue(':login', $user->login());
        $q->bindValue(':email', $user->email());
        $q->bindValue(':password', $user->password());
        $q->bindValue(':validated', $user->validated());
        $q->bindValue(':role', $user->role());
        $q->bindValue(':validationToken', $user->validationToken());

        $q->execute();
    }
}
