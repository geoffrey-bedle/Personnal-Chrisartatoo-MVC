<?php


namespace App\Model;

class ImageManager extends AbstractManager
{
    const TABLE = 'images';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insertImage($category, $image)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`,`categories_id`)
 VALUES (:image, :categories_id)");
        $statement->bindValue('categories_id', $category['category'], \PDO::PARAM_INT);
        $statement->bindValue('image', $image, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function selectAllById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE categories_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function deleteById($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
