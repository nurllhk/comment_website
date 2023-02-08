<?php
if (substr_count(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {ob_start("ob_gzhandler"); }else {ob_start(); }
@session_start();
date_default_timezone_set('Europe/Istanbul');
setlocale(LC_MONETARY, 'it_IT');
setlocale(LC_TIME,'turkish');
define("ROOT_FOLDER", dirname(__FILE__));
require_once(ROOT_FOLDER.'/config.php');
if(DEBUG)
{
	error_reporting(-1);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
else
{
	error_reporting(0);
}
if(DATABASE)
{
require_once(ROOT_FOLDER.'/includes/lib/db.php');
$db = new DB();
}


// LIB


require_once(ROOT_FOLDER.'/includes/lib/functions.php');
require_once(ROOT_FOLDER.'/includes/lib/helper.php');
require_once(ROOT_FOLDER.'/includes/lib/upload.php');
require_once(ROOT_FOLDER.'/includes/lib/user.php');
require_once(ROOT_FOLDER.'/includes/lib/design_functions.php');
require_once(ROOT_FOLDER.'/includes/lib/email_template.php');
require_once(ROOT_FOLDER.'/includes/lib/captcha.class.php');

// REVIEW


require_once(ROOT_FOLDER.'/includes/review/helper.php');
require_once(ROOT_FOLDER.'/includes/review/permalinks.php');
require_once(ROOT_FOLDER.'/includes/review/functions.php');
require_once(ROOT_FOLDER.'/includes/review/friendship.php');
require_once(ROOT_FOLDER.'/includes/review/support.php');
require_once(ROOT_FOLDER.'/includes/review/plagiarism.php');
require_once(ROOT_FOLDER.'/includes/review/data_table.php');

// MODULES

require_once(ROOT_FOLDER.'/includes/modules/PHPMailer/PHPMailerAutoload.php');
require_once(ROOT_FOLDER.'/includes/modules/Mobile_Detect/Mobile_Detect.php');


//THEME

define('SITE_THEMES_URL',SITE_DOMAIN.'/themes');
define('SITE_THEME_URL',SITE_THEMES_URL.'/'.SITE_THEME);
define('SITE_THEME_DIR',ROOT_FOLDER.'/themes/'.SITE_THEME);

define('USER_LEVELS',$db->table('user_levels')->get()['data']);
define('SETTINGS',$db->table('settings')->where('id','=','1')->get()['data'][0]);

$memory_categories = array();
$categories = $db->table('categories')->get();

foreach($categories['data'] as $category)
{
	foreach($category as $key => $value)
	{
		$memory_categories[$category['id']][$key] = $value;
	}
}

define('CATEGORIES',$memory_categories);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if(m_user_check() and m_user_check_control())
{
	define('USER',m_user());
	
}
else
{
	define('USER',false);
}


?>