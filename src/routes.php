<?php

//Use model classes

use Slim\App;
use App\Post;
use App\Comment;

//routes


$container = $app->getContainer();

//display index page
$app->get('/', function ($request, $response, $args) {
    //$this->logger->info("index'/' route");
    //new post object
    $post = new Post ($this->db);
    //Calls get posts method
    $results = $post->getPosts();
    //pass $results to the view ndex.twig template
    $args['posts'] = $results;
    // Render index view
    return $this->view->render($response, 'index.twig', $args);
});

//Publish new entry page/form
$app->get('/new', function($request, $response) {
  return $this->view->render($response, 'new.twig');
});





// Create Post route to db

//Need to Redirect to index
$app->post('/new', function($request, $response, $args) {
//if ($request->getMethod() == 'PUT') {

$post = new Post($this->db);
$args = array_merge($args, $request->getParsedBody());

$args['date'] = date('Y-m-d');

  // Add post
  if (!empty($args['title']) && !empty($args['date']) && !empty($args['body'])) {
  //$this->logger->notice(json_encode([$args['name'], $args['body']]));
  $results = $post->createPost($args['title'], $args['date'], $args['body']);
  $args['post'] = $results;

}
$url = $this->router->pathFor('post-detail');
return $response->withStatus(302)->withHeader('Location',$url);
//return $this->view->render($response, 'index.twig', $args);
})->setName('post-detail');





//details

$app->map(['GET'], '/{id}', function ($request, $response, $args) {
    $post = new Post($this->db);
    //$comment = new Comment($this->db);


    if ($request->getMethod() == 'POST') {
        $args = array_merge($args, $request->getParsedBody());
        if (!empty($args['name']) && !empty($args['body'])) {
            $this->logger->notice(json_encode([$args['name'], $args['body']]));
            $comment->getComments($args['name'], $args['body'], $args['id']);
            $url = $this->router->pathFor(
                'createPost',
                ['id' => $args['id'], 'post_title' => $args['post_title']]
            );
            return $response->withStatus(302)->withHeader('Location', $url);
        }
        $args['error'] = 'All fields are required.';
    }

    $this->logger->info('/details');
    $createPost = $post->getAPost($args['id']);
    $args['post'] = $createPost;
    $comments = $comment->getComments($createPost['id']);
    $args['comments'] = $comments;
    if (empty($createPost)) {
        $url = $this->router->pathFor('createPost');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
        $args['save'] = $_POST;
        return $this->view->render($response, 'details.twig', $args);
})->setName('createPost');
