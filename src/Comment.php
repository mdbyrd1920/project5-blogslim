<?php
namespace App;
use \PDO;

class Comment
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
/*
//prepare statement that Get all Comments to display
    public function getComments()
    {
      $results = $this->db->prepare(
                 'SELECT * FROM comments WHERE id = ? '
);
             $results->bindParam(1, $id, \PDO::PARAM_INT);
             $results->execute();
             $comment = $results->fetchAll();

        /*if (empty($posts)) {
            throw new ApiException(ApiException::REVIEW_NOT_FOUND, 404);
        }
        return $comment;
    }
*/
//
    public function getComments($postId)
  {
      $results = $this->db->prepare(
         'SELECT * FROM comments WHERE postId=:postId'
      );
      $results->bindParam('postId', $postId);
      $results->execute();
      return $results->fetchAll(PDO::FETCH_ASSOC);
      /*if (empty($post)) {
          throw new ApiException(ApiException::ENTRY_NOT_FOUND, 404);
      }*/
      return $comment;
    }

    public function createComment($name, $comment, $postId)
    {

        $results = $this->db->prepare('INSERT INTO comments (name, body, postId)
				VALUES(:name, :body, :postId)');
        $results->bindParam(':name', $name, PDO::PARAM_STR);
		    $results->bindParam(':body', $comment, PDO::PARAM_STR);
		    $results->bindParam(':postId', $postId, PDO::PARAM_INT);
	//	$results->bindParam(':date', $date, PDO::PARAM_STR);
		$results->execute();
		return true;
    }
/*
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
        }
        return $results->fetch();
    } */
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
