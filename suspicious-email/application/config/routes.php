<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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



$route['default_controller'] = 'web_panel/Register';
$route['404_override'] = '';
$route['about-us'] = 'web_panel/About_us';
$route['our-business'] = 'web_panel/Our_business';
$route['our-team'] = 'web_panel/Our_team';
$route['vision-mision'] = 'web_panel/Vision_mission';
$route['our-gallery'] = 'web_panel/Gallery';
$route['our-video'] = 'web_panel/Video';
$route['metro-mart-career'] = 'web_panel/Career';
$route['work-culture'] = 'web_panel/Work_culture';
$route['franchise-business'] = 'web_panel/Franchise_business';
$route['franchise-process'] = 'web_panel/Franchise_process';
$route['apply-for-franchise'] = 'web_panel/Franchise';
$route['contact-us'] = 'web_panel/Contact_us';
$route['login'] = 'web_panel/Login';
$route['register'] = 'web_panel/Register';
$route['franchise-download'] = 'web_panel/Franchise_download';
$route['contact-us'] = 'web_panel/Contact_us';

$route['home'] = "web_panel/Home";
$route['add-to-cart'] = 'web_panel/Cart/add_to_cart';
$route['show-cart'] = 'web_panel/Cart/show_cart';
$route['delete-to-cart/(.+)'] = 'web_panel/Cart/delete_to_cart/$1';
$route['update-cart-qty'] = 'web_panel/Cart/update_cart_quantity';
$route['update-cart-qty-payment'] = 'web_panel/Cart/update_cart_quantity_payment';
$route['delete-to-cart-payment/(.+)'] = 'web_panel/Cart/delete_to_cart_payment/$1';


$route['checkout'] = 'web_panel/Checkout/checkout';
$route['customer-registration'] = 'web_panel/Checkout/customer_registration';
$route['customer-login'] = 'web_panel/Checkout/customer_login';
$route['billing'] = 'web_panel/Checkout/billing';
$route['shipping'] = 'web_panel/Checkout/shipping';
$route['update-billing'] = 'web_panel/Checkout/update_billing';
$route['insert-shipping'] = 'web_panel/Checkout/insert_shipping';
$route['payment'] = 'web_panel/Checkout/payment';
$route['place-order'] = 'web_panel/Checkout/place_order';
$route['logout'] = 'web_panel/Checkout/customer_logout';
$route['order-success'] = 'web_panel/Checkout/order_success';
$route['translate_uri_dashes'] = FALSE;

