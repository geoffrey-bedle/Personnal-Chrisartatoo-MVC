<?php


namespace App\Model;

class EvenementsManager extends AbstractManager
{
    const TABLE = 'evenements';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($evenement)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`,`date`)
 VALUES (:name, :date)");
        $statement->bindValue('name', $evenement['evenment'], \PDO::PARAM_STR);
        $statement->bindValue('date', $evenement['date'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function delete($id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

//TODO finish function update evenment
    public function update($id, $item)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table 
                                             SET `name` = :name, `date`= :date
                                             WHERE id= :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('name', $item['name'], \PDO::PARAM_STR);
        $statement->bindValue('date', $item['date'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
