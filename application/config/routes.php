<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//authentication
$route['register']['GET'] = 'Auth/RegisterController/index';
$route['login']['GET'] = 'Auth/LoginController/index';
$route['login']['POST'] = 'Auth/LoginController/login';
$route['register']['POST'] = 'Auth/RegisterController/register';
$route['logout']['GET'] = 'Auth/LoginController/logout';

// migration
$route['migrate'] = 'MigrationController/index';

// dashboard
$route['dashboard']['GET'] = 'DashboardController/index';

// user crud
$route['user']['GET'] = 'UserController/index';
$route['user/store'] = 'UserController/store';
$route['user/update'] = 'UserController/update';
$route['user/delete'] = 'UserController/delete';
$route['user/edit/(:any)'] = 'UserController/edit/$1';
$route['user/table']['GET'] = 'UserController/table';

// category crud
$route['category']['GET'] = 'CategoryController/index';
$route['category/store'] = 'CategoryController/store';
$route['category/update'] = 'CategoryController/update';
$route['category/delete'] = 'CategoryController/delete';
$route['category/edit/(:any)'] = 'CategoryController/edit/$1';
$route['category/table']['GET'] = 'CategoryController/table';

// product crud
$route['product']['GET'] = 'ProductController/index';
$route['product/store'] = 'ProductController/store';
$route['product/update'] = 'ProductController/update';
$route['product/delete'] = 'ProductController/delete';
$route['product/edit/(:any)'] = 'ProductController/edit/$1';
$route['product/table']['GET'] = 'ProductController/table';

//order management
$route['order']['GET'] = 'TransactionController/order';
$route['order-table']['GET'] = 'TransactionController/order_table';
$route['payment']['GET'] = 'TransactionController/payment';
$route['payment-table']['GET'] = 'TransactionController/payment_table';

//home
$route['default_controller'] = 'HomeController/index';
$route['shop'] = 'HomeController/shop';
$route['shop/(:any)'] = 'HomeController/detail/$1';

//cart
$route['cart'] = 'CartController/index';
$route['all-cart'] = 'CartController/all';
$route['cart/delete'] = 'CartController/delete';
$route['cart/update'] = 'CartController/update';
$route['cart/create'] = 'CartController/store';


//midtrans
$route['snap'] = 'Midtrans/SnapController/index';
$route['snap/token'] = 'Midtrans/SnapController/token';
$route['snap/finish'] = 'Midtrans/SnapController/finish';
$route['notification'] = 'Midtrans/Notification/index';

//order-list
$route['order-list'] = 'OrderController/index';
$route['order-list/(:any)'] = 'OrderController/detail/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
