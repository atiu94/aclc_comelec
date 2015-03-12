<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// Set the default controller of the site.
$route['default_controller'] = "site/welcome/index";

// Redirect all admin requests to the admin folder.
$route['admin'] = "admin";
$route['admin/login'] = "admin/index/index";
$route['admin/forbidden'] = "admin/index/forbidden";
$route['admin/(:any)'] = "admin/$1";

// Redirect all dev requests to the dev folder.
$route['dev'] = "dev/index";
$route['dev/(:any)'] = "dev/$1";

// Redirect all test requests to the test folder.
$route['test'] = "test/index";
$route['test/(:any)'] = "test/$1";

// Redirect all api requests to the api folder.
$route['api'] = "api/index";
$route['api/(:any)'] = "api/$1";

require('database.php');
$dbconf = $db[$active_group];
@$mysqli = new mysqli($dbconf['hostname'], $dbconf['username'], $dbconf['password'], $dbconf['dbprefix'] . $dbconf['database']);
if($mysqli->connect_errno) 
{
	die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Redirect all page request to the site/page controller.
$res = $mysqli->query("SELECT pag_slug FROM page WHERE pag_status = 'published'");
while($row = $res->fetch_assoc())
{
	$route[$row['pag_slug']] = 'site/page/index/' . $row['pag_slug'];
}

/*
Redirect all other pages to the site folder. 

No need to add the "site" folder when creating links.

Example:
http://www.mysite.com/signup/newuser will point to your site/signup controller 
and will call the newuser() function.

Always keep this at the bottom of this list (catch-all routing rule).
*/
$route['(:any)'] = "site/$1";

// Redirect all 404 errors to this controller.
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
