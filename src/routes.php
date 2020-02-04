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



// Add a new post
$app->post('/post/new', function($request, $response, $args) {
  // Getting form data with post details
  $args = array_merge($args, $request->getParsedBody());


  $args['date'] = date('Y-m-d');

  // Add post
  if (!empty($args['title']) && !empty($args['date']) && !empty($args['entry'])) {

      $post = new Post($this->db);
      $results = $post->createPost($args['title'], $args['date'], $args['entry']);
      $args['posts'] = $results;

     }
 return $this->view->render($response, 'index.twig', $args);

});


//display sinlge post
$app->map(['GET', 'PUT'],'/posts/{id}', function ($request, $response, $args) {
        if ($request->getMethod() == 'POST') {
    $args = array_merge($args, $request->getParsedBody());

      $post = new Post ($this->db);
      $results = $post->getPost($args['id']);

      $args['posts'] = $results;

      $comments = new Comment($this->db);
      $resultsComm = $comments->getComments($args['id']);

    if (!empty($postComm)) {
      $args['comments'] = $resultsComm;
}


  return $this->view->render($response, "index.twig", $args);
/* [
  'posts' => $post,
  'comments' => $comments
]); */

}
});
