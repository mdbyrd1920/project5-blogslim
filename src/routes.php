<?php

//Use model classes

use Slim\App;
use App\Post;
use App\Comment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

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
$url = $this->router->pathFor('new');
return $response->withStatus(302)->withHeader('Location', '/');
//return $this->view->render($response, 'index.twig', $args);
})->setName('new');


//details

$app->map(['GET', 'POST'], '/detail/{id}', function($request, $response, $args) {

$post = new Post($this->db);
$comment = new Comment($this->db);
$this->logger->info('/details');

$results = $post->getAPost($args['id']);
$args['post'] = $results;
$results_comments = $comment->getComments($args['id']);
$args['comments'] = $results_comments;


//render detail view
    return $this->view->render($response, 'detail.twig', $args);

})->setName('detail');



//edit

$app->map(['GET', 'PUT'], '/edit/{id}', function ($request, $response, $args) {

  $post = new Post ($this->db);
  //Calls get posts method
  $results = $post->getPosts();
  //pass $results to the view ndex.twig template
  $args['posts'] = $results;
  // Render index view
  return $this->view->render($response, 'edit.twig', $args);
});
