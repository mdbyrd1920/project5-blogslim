<?php
namespace App;
use \PDO;


class Post
{
    protected $db;
    public function __construct(\PDO $db)
    {
      //connection to database
        $this->db = $db;
    }

//Function method that Get all Posts to display


    public function getPosts()
    {

      $results = $this->db->prepare("SELECT * FROM posts ORDER BY date DESC");
      $results->execute();
      return $results->fetchAll(PDO::FETCH_ASSOC);
        /*if (empty($posts)) {
            throw new ApiException(ApiException::REVIEW_NOT_FOUND, 404);
        }*/
        return $post;
    }


    public function getAPost($id)
  {
      $results = $this->db->prepare(
         'SELECT * FROM posts WHERE id=:id'
      );
      $results->bindParam('id', $id);
      $results->execute();
      $post = $results->fetch();
      /*if (empty($post)) {
          throw new ApiException(ApiException::ENTRY_NOT_FOUND, 404);
      }*/
      return $post;
    }

//Add/create post

// add Post //to database
    public function createPost($title, $date, $body)
    {
        /*if (empty($data['post_id']) || empty($data['rating']) || empty($data['comment'])) {
            throw new ApiException(ApiException::REVIEW_INFO_REQUIRED);
        }*/
        $results = $this->db->prepare('INSERT INTO posts (title, date, body) VALUES (:title, :date, :body)');
        $results->bindParam(':title', $title, PDO::PARAM_STR);
        $results->bindParam(':date', $date, PDO::PARAM_STR);
        $results->bindParam(':body', $body, PDO::PARAM_STR);
        $results->execute();
      /*  if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::REVIEW_CREATION_FAILED);
        }*/
        return true;
    }


//updatePost/edit
    public function updatePost($id, $title, $date, $body)
    {
        $this->getAPost($id, $title, $date, $body);
        $results = $this->db->prepare('UPDATE posts SET title = :title, date = :date, body = :body WHERE id = :id');
        $results->bindParam(':id', $id, PDO::PARAM_INT);
        $results->bindParam(':title', $title, PDO::PARAM_STR);
        $results->bindParam(':date', $date, PDO::PARAM_STR);
        $results->bindParam(':body', $body, PDO::PARAM_STR);
        $results->execute();
        /*if ($statement->rowCount()<1) {\
            throw new ApiException(ApiException::REVIEW_UPDATE_FAILED);
        }*/
              return true;
    }

// deletePost
    public function deletePost($id)
    {
        $this->getPost($id);
        $results = $this->db->prepare('DELETE FROM posts WHERE id=:id');
        $results->bindParam('id', $id);
        $results->execute();
        /*if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::REVIEW_DELETE_FAILED);
        }*/
        return ['message' => 'The post was deleted.'];
    }
}
