<?php

namespace App\Model\Users;

class UsersManagerPDO extends UsersManager
{
    public function getByEmail($email)
    {
        $query = $this->dao->prepare('SELECT id, login, email, validated, role, password, validationToken FROM users WHERE email = :email');
        $query->bindValue(':email', (string) $email, \PDO::PARAM_STR);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Users\User');

        if ($user = $query->fetch()) {
            return $user;
        }

        return null;
    }

    public function getAdminList()
    {
        $query = $this->dao->prepare('SELECT id, login, email, validated, role FROM users WHERE role = :role AND validated = :validated');
        $query->bindValue(':role', (string) 1, \PDO::PARAM_INT);
        $query->bindValue(':validated', (string) 1, \PDO::PARAM_INT);
        $query->execute();

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'App\Model\Users\User');

        $result = $query->fetchAll();
        $query->closeCursor();

        return $result;
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    protected function add(User $user)
    {
        $query = $this->dao->prepare('INSERT INTO users SET login = :login, email = :email, password = :password, validated = :validated, role = :role, validationToken = :validationToken');

        $query->bindValue(':login', $user->login());
        $query->bindValue(':email', $user->email());
        $query->bindValue(':password', $user->password());
        $query->bindValue(':validated', $user->validated());
        $query->bindValue(':role', $user->role());
        $query->bindValue(':validationToken', $user->validationToken());

        $query->execute();
    }

    public function validateAccount($idUser)
    {
        $query = $this->dao->prepare('UPDATE users SET validated = :validated WHERE id = :id');

        $query->bindValue(':validated', 1, \PDO::PARAM_INT);
        $query->bindValue(':id', $idUser, \PDO::PARAM_INT);

        $query->execute();
    }
}
