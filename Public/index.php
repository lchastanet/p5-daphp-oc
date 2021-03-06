<?php

require '../vendor/autoload.php';

App\lib\Authenticator::initSession();

$config = new App\lib\Config();

$router = new AltoRouter();
$router->setBasePath($config->getBasePath());

$router->map('GET', '/', 'App\Controllers\News\NewsController#executeHome');
$router->map('GET', '/listNews/[i:index]', 'App\Controllers\News\NewsController#executeList');
$router->map('GET', '/news/[i:idNews]', 'App\Controllers\News\NewsController#executeShow');
$router->map('POST', '/insertComment/[i:idNews]', 'App\Controllers\Comments\CommentsController#executeInsert');
$router->map('GET|POST', '/signIn', 'App\Controllers\Users\UsersController#executeSignIn');
$router->map('GET|POST', '/signUp', 'App\Controllers\Users\UsersController#executeSignUp');
$router->map('GET', '/admin', 'App\Controllers\Users\Admin\UsersController#executeHome');
$router->map('GET', '/logout', 'App\Controllers\Users\Admin\UsersController#executeLogout');
$router->map('GET', '/admin/listNews', 'App\Controllers\News\Admin\NewsController#executeList');
$router->map('GET|POST', '/admin/addNews', 'App\Controllers\News\Admin\NewsController#executeAddNews');
$router->map('GET', '/admin/listComments', 'App\Controllers\Comments\Admin\CommentsController#executeAdminList');
$router->map('GET', '/admin/commentValidation/[i:id]', 'App\Controllers\Comments\Admin\CommentsController#executeCommentValidation');
$router->map('GET', '/admin/deleteComment/[i:id]', 'App\Controllers\Comments\Admin\CommentsController#executeDelete');
$router->map('GET|POST', '/admin/updateNews/[i:id]', 'App\Controllers\News\Admin\NewsController#executeUpdateNews');
$router->map('GET', '/admin/deleteNews/[i:id]', 'App\Controllers\News\Admin\NewsController#executeDelete');
$router->map('GET', '/validateAccount/[*:mail]/[h:validationToken]', 'App\Controllers\Users\UsersController#executeValidateAccount');
$router->map('POST', '/contactForm', 'App\Controllers\PublicController#executeContactForm');

$match = $router->match();

if ($match) {
    list($controller, $action) = explode('#', $match['target']);

    if (class_exists($controller)) {
        $controller = new $controller();

        if (is_callable([$controller, $action])) {
            call_user_func_array([$controller, $action], $match['params']);
        } else {
            throw new \Exception('Aucune action ne correspond à la route demandée!');
        }
    } else {
        throw new \Exception('Aucun controlleur ne correspond à la route demandée!');
    }
} else {
    $controller = new App\Controllers\PublicController();
    $controller->executeError(404);
}
