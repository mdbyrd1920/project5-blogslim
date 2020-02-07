<?php
namespace App\Comment;
use \PDO;

class Comment
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

//prepare statement that Get all Comments to display
    public function getComments()
    {
      $statment = $this->db->prepare(
                 'SELECT * FROM comments WHERE id = ? ORDER BY date DESC'
             );
             $statemnt->execute();
             $comments = $results->fetchAll();

        /*if (empty($posts)) {
            throw new ApiException(ApiException::REVIEW_NOT_FOUND, 404);
        }*/
        return $comments;
    }

//
    public function getComment($id)
  {
      $statment = $this->db->prepare(
         'SELECT * FROM comments WHERE id=:id'
      );
      $results->bindParam('id', $id);
      $statment->execute();
      $comment = $statemnt->fetch();
      /*if (empty($post)) {
          throw new ApiException(ApiException::ENTRY_NOT_FOUND, 404);
      }*/
      return $comment;
    }

    public function createComment($title, $date, $body)
    {
        /*if (empty($data['post_id']) || empty($data['rating']) || empty($data['comment'])) {
            throw new ApiException(ApiException::REVIEW_INFO_REQUIRED);
        }*/
        $results = $this->db->prepare('INSERT INTO comments (title, date, body) VALUES (:title, :date, :body)');
        $results->bindParam('title', $title, PDO::PARAM_STR);
        $results->bindParam('date', $date, PDO::PARAM_STR);
        $results->bindParam('body', $body, PDO::PARAM_STR);
        $results->execute();
      /*  if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::REVIEW_CREATION_FAILED);
        }*/
        return $this->getComment($this->db->lastInsertId());
    }

    public function updateComment($title, $date, $body)
    {
        $this->getComment($id, $title, $date, $body);
        $results = $this->db->prepare('UPDATE comments SET rating=:rating, comment=:comment WHERE id=:id');
        $results->bindParam('id', $id, PDO::PARAM_INT);
        $results->bindParam('title', $title, PDO::PARAM_STR);
        $results->bindParam('date', $date, PDO::PARAM_STR);
        $results->bindParam('body', $body, PDO::PARAM_STR);
        $results->execute();
        /*if ($statement->rowCount()<1) {\
            throw new ApiException(ApiException::REVIEW_UPDATE_FAILED);
        }*/
        return $statment->fetch();
    }
    public function deleteComment($id)
    {
        $this->getComment($id);
        $results = $this->db->prepare('DELETE FROM comments WHERE id=:id');
        $results->bindParam('id', $id);
        $results->execute();
        /*if ($statement->rowCount()<1) {
            thrresultsiException(ApiException::REVIEW_DELETE_FAILED);
        }*/
        return ['message' => 'The comment was deleted.'];
    }
}
