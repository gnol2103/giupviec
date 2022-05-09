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


MVC
URL = CONTROLLER/function
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// (:any) -> thể hiện 1 chuỗi bất kỳ 12312312aabc-zxczxc
// (:num) -> thể hiện 1 dãy số VD: 1234

// Url: (:any)-kitu{$id}: VD: may-cham-cong-may-cham-cong-van-tay-500-p1.html

$route['(:any)-p(:num).html'] = 'Views/ProductController/show/$1/$2';

$route['(:any)-m(:num).html'] = 'Views/ManufacturerController/index/$1/$2';

$route['(:any)-c(:num).html'] = 'Views/CategoryController/index/$1/$2';

$route['login'] = 'Views/Home/User/LoginController/index';

$route['login/employee'] = 'Views/Home/User/LoginController/login_employee';

$route['login/company'] = 'Views/Home/User/LoginController/login_company';

$route['register'] = 'Views/Home/User/RegisterController/index';

$route['register/employee'] = 'Views/Home/User/RegisterController/register_employee';

$route['register/company'] = 'Views/Home/User/RegisterController/register_company';

$route['register/employee/success'] = 'Views/Home/User/RegisterController/register_employee_success';

$route['register/company/success'] = 'Views/Home/User/RegisterController/register_company_success';

$route['verify'] = 'Views/Home/User/VerifyController/index';

$route['forgot-password'] = 'Views/Home/User/PasswordController/forgot_password';

$route['forgot-password/send'] = 'Views/Home/User/PasswordController/forgot_password_send';

$route['reset-password'] = 'Views/Home/User/PasswordController/reset_password';

$route['reset-password/success'] = 'Views/Home/User/PasswordController/reset_password_success';

$route['error'] = 'Views/Home/User/PasswordController/error';
