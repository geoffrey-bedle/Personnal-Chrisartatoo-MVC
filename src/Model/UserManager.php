<?php


namespace App\Model;

class UserManager extends AbstractManager
{
    const TABLE = 'User';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectByEmail($email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email= :email");
        $statement->bindValue(':email', $email['email'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
