<?php


namespace App\Model;

class ArticleManager extends AbstractManager
{

    const TABLE = 'article';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert($data, $image)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`,`date`,`content`,`image`)
 VALUES (:title, :date, :content, :image)");
        $statement->bindValue('title', $data['title'], \PDO::PARAM_STR);
        $statement->bindValue('date', $data['date'], \PDO::PARAM_STR);
        $statement->bindValue('content', $data['content'], \PDO::PARAM_STR);
        $statement->bindValue('image', $image, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function delete($id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function update($id, array $item): bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table 
                                             SET `title` = :title, `content`= :content, `date`= :date, `image` = :image 
                                             WHERE id= :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);
        $statement->bindValue('content', $item['content'], \PDO::PARAM_STR);
        $statement->bindValue('date', $item['date'], \PDO::PARAM_STR);
        $statement->bindValue('image', $item['image'], \PDO::PARAM_STR);


        return $statement->execute();
    }
}
