<?php defined('DACCESS') or die ('Access Denied!');
/**
 * Definition of the url access. 
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

/* Default routes, DO NOT DELETE!!! */
$route['default_controller'] = 'home';
$route['default_404'] = 'notfound';
$route['default_offline'] = 'offline';
/* user-defined routes */
$route['home'] = 'booklist';
$route['login'] = 'login';
$route['login/forgotpassword'] = 'login/forgotpassword';

$route['logout'] = 'booklist/logout';
$route['publish'] = 'publish';
$route['publish/logout'] = 'publish/logout';
$route['publish/edit'] = 'publish/edit';
$route['admin'] = 'admin';
$route['admin/edit'] = 'admin/edit';
$route['admin/logout'] = 'admin/logout';
$route['users'] = 'users'; // --> new users route

$route['events'] = 'events';
$route['profile'] = 'profile';
$route['authors'] = 'authors';
$route['categories'] = 'categories';
$route['banner'] = 'banner';
$route['utilities'] = 'utilities';

$route['feed'] = 'feed';

$route['development/login'] = 'login';
$route['development/login/forgotpassword'] = 'login/forgotpassword';
$route['development/publish'] = 'publish';
$route['development/publish/logout'] = 'publish/logout';
$route['development/publish/edit'] = 'publish/edit';
$route['development/admin'] = 'admin';
$route['development/admin/edit'] = 'admin/edit';
$route['development/admin/logout'] = 'admin/logout';

$route['users'] = 'users'; // --> new users route
