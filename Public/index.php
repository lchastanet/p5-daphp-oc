<?php

require '../vendor/autoload.php';

session_start();

$config = new App\lib\Config();

$router = new AltoRouter();
$router->setBasePath($config->getBasePath());

$router->map('GET', '/', 'App\Controllers\News\NewsController#executeList');
$router->map('GET', '/news/[i:id]', 'App\Controllers\News\NewsController#executeShow');
$router->map('POST', '/insertComment/[i:idNews]', 'App\Controllers\Comments\CommentsController#executeInsert');
$router->map('GET|POST', '/signIn', 'App\Controllers\Users\UsersController#executeSignIn');
$router->map('GET|POST', '/signUp', 'App\Controllers\Users\UsersController#executeSignUp');
$router->map('GET', '/admin', 'App\Controllers\Users\admin\UsersController#executeHome');
$router->map('GET', '/logout', 'App\Controllers\Users\admin\UsersController#executeLogout');
$router->map('GET', '/admin/listNews', 'App\Controllers\News\admin\NewsController#executeList');
$router->map('GET|POST', '/admin/addNews', 'App\Controllers\News\admin\NewsController#executeAddNews');
$router->map('GET', '/admin/listComments', 'App\Controllers\Comments\admin\CommentsController#executeAdminList');
$router->map('GET', '/admin/commentValidation/[i:id]', 'App\Controllers\Comments\admin\CommentsController#executeCommentValidation');
$router->map('GET', '/admin/deleteComment/[i:id]', 'App\Controllers\Comments\admin\CommentsController#executeDelete');
$router->map('GET|POST', '/admin/updateNews/[i:id]', 'App\Controllers\News\admin\NewsController#executeUpdateNews');
$router->map('GET', '/admin/deleteNews/[i:id]', 'App\Controllers\News\admin\NewsController#executeDelete');

$match = $router->match();

if ($match) {
    list($controller, $action) = explode('#', $match['target']);

    if (is_callable([$controller, $action])) {
        $controller = new $controller();
        call_user_func_array([$controller, $action], $match['params']);
    } else {
        throw new \Exception('Aucun controlleur ou action ne correspond à la route demandée!');
    }
} else {
    $controller = new App\Controllers\PublicController();
    $controller->executeError(404);
}
