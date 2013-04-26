<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * SITE CONSTANTS
*/
define('SITENAME', 'Knights ');
define('SITEPATH', preg_replace('@/'.SYSDIR.'@i','',BASEPATH));
define('THEME_URL','/themes/default');
define('ADMIN_THEME_URL','/themes/wireframes');
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');



/*
 |--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
|
| Messages used throughout application
|
*/

define('REQUIRE_LOGIN_MSG',				'');
define('INSUFFICIENT_PERMISSION_MSG',	'You do not have the appropriate permissions to use this feature.');
define('PERMISSION_FUBAR_MSG',			'The page is requesting a permission set that does not exisit. Please contact your administrator.');
define('NEW_ACCT_MSG',					'Your account has been created. Please log in.');
define('DEL_ACCT_MSG',					'The selected account has been deleted');

/* End of file constants.php */
/* Location: ./application/config/constants.php */