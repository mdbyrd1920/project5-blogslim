<?php

//Use model classes

use Slim\App;
use App\Post;
use App\Comment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

//routes

//$app = app object for slim
$container = $app->getContainer();


//Publish new entry page/form
//get method for new twig/page route
$app->get('/new', function($request, $response) {
    // Render new entry view
    return $this->view->render($response, 'new.twig');
});

// Create Post route to db
// post method for new twig/page route for form
$app->post('/new', function($request, $response, $args) {
    //new post object
    $post = new Post($this->db);


    //post details are stored in $request->getParsedBody()
    //save values
    //merge args array
    //post values in args array
    $args = array_merge($args, $request->getParsedBody());

    //date 
    $args['date'] = date('Y-m-d');

  // Add post
  // vaildation if title date & body are set log details
  if (!empty($args['title']) && !empty($args['date']) && !empty($args['body'])) {
    //Calls create post method
    $results = $post->createPost($args['title'], $args['date'], $args['body']);
    //add posts to args array
    $args['posts'] = $results;

}
    //set url new
    //router uses request & respond cycle
    $url = $this->router->pathFor('new');
    //redirect to index
    return $response->withStatus(302)->withHeader('Location', '/');
    })->setName('new');


//get method for detail twig/page route
$app->get('/detail/{id}', function($request, $response, $args) {
    //new post object
    $post = new Post($this->db);
    //new comment object
    $comment = new Comment($this->db);
    $this->logger->info('/details');

    $results = $post->getAPost($args['id']);
    $args['post'] = $results;
    //Calls get comments method
    $results_comments = $comment->getComments($args['id']);
    $args['comments'] = $results_comments;

    //render detail view
    return $this->view->render($response, 'detail.twig', $args);
//name route to call detail route
})->setName('detail');

//post method for detail twig/page route
//add name & comment to post
$app->post('/detail/{id}', function($request, $response, $args) {

    $args = array_merge($args, $request->getParsedBody());

    //new comment object
    // Add Comment
    $comment = new Comment($this->db);
      //Calls create comment method
    $blogComment = $comment->createComment($args['name'], $args['comment'], $args['id']);

    //redirect to detail view
    return $this->response->withStatus(302)->withHeader('Location', '/detail/'. $args['id']);
  });



//Edit an entry/post with details displayed
//combine both get & post routes
//http method to match
$app->map(['GET', 'POST'], '/edit/{id}', function ($request, $response, $args) {
    //new post object
    $post = new Post ($this->db);
    $this->logger->info('/edit');

    //Calls get a post method
    //Edit an entry/post with details displayed
    $results = $post->getAPost($args['id']);

    //pass $results to the view edit.twig template
    $args['post'] = $results;

//run only on post
  if($request->getMethod() == "POST") {
    $args = array_merge($args, $request->getParsedBody());

    //Calls get update post method
    //Ability to edit & save changes
    $results = $post->updatePost($args['id'], $args['title'], $args['date'], $args['body']);

    // View updated post
    //redirect to detail view
    return $this->response->withStatus(302)->withHeader('Location', '/detail/'. $args['id'] );

    // Render edit view
    } return $this->view->render($response, 'edit.twig', $args);
});

//get method for index twig/page route
//display index page with blog entries
$app->get('/', function ($request, $response, $args) {
    //new post object
    $post = new Post ($this->db);
    //Calls get posts method
    $results = $post->getPosts();
    //pass $results to the view index.twig template
    $args['posts'] = $results;

    // Render index view
    return $this->view->render($response, 'index.twig', $args);
});
