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

//Gets one post
    public function getPost($post_id)
  {
      $results = $this->db->prepare(
         'SELECT * FROM posts WHERE post_id=:post_id'
      );
      $results->bindParam('post_id', $post_id);
      $results->execute();
      $post = $results->fetch();
      /*if (empty($post)) {
          throw new ApiException(ApiException::ENTRY_NOT_FOUND, 404);
      }*/
      return $post;
    }

//Add/create post
    public function createPost($title, $date, $body)
    {
        /*if (empty($data['post_id']) || empty($data['rating']) || empty($data['comment'])) {
            throw new ApiException(ApiException::REVIEW_INFO_REQUIRED);
        }*/
        $results = $this->db->prepare('INSERT INTO posts (title, date, body) VALUES (:title, :date, :body)');
        $results->bindParam('title', $title, PDO::PARAM_STR);
        $results->bindParam('date', $date, PDO::PARAM_STR);
        $results->bindParam('body', $body, PDO::PARAM_STR);
        $results->execute();
      /*  if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::REVIEW_CREATION_FAILED);
        }*/
        return true;
    }
    public function updatePost($title, $date, $body)
    {
        $this->getPost($post_id, $title, $date, $body);
        $results = $this->db->prepare('UPDATE posts SET comment=:comment WHERE post_id=:post_id');
        $results->bindParam('post_id', $post_id, PDO::PARAM_INT);
        $results->bindParam('title', $title, PDO::PARAM_STR);
        $results->bindParam('date', $date, PDO::PARAM_STR);
        $results->bindParam('body', $body, PDO::PARAM_STR);
        $results->execute();
        /*if ($statement->rowCount()<1) {\
            throw new ApiException(ApiException::REVIEW_UPDATE_FAILED);
        }*/
        return $results->fetch();
    }


    public function deletePost($post_id)
    {
        $this->getPost($post_id);
        $results = $this->db->prepare('DELETE FROM posts WHERE post_id=:post_id');
        $results->bindParam('post_id', $post_id);
        $results->execute();
        /*if ($statement->rowCount()<1) {
            throw new ApiException(ApiException::REVIEW_DELETE_FAILED);
        }*/
        return ['message' => 'The post was deleted.'];
    }
}
