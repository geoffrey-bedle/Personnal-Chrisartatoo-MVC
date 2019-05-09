<?php


namespace App\Model;

class CategoriesManager extends AbstractManager
{
    const TABLE = 'categories';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($data, $image)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`,`image`)
 VALUES (:name, :image)");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('image', $image, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function deleteById($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
