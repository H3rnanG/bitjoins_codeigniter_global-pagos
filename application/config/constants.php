<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('ON','1');
define('OFF','2');
define('TKN','3');

define('SE_CARRITO', '1500');

define('STRKEY', 'APCK1');

define('INICOD', 'PB');

define('KPASS','123456');

define('TP_TRANSFERENCIA', '1');

define('UPLOAD', dirname($_SERVER["SCRIPT_FILENAME"])."/assets/upload/");
define('PATH_DOCS', dirname($_SERVER["SCRIPT_FILENAME"])."/docs/");

define('TC', '1');
define('UTILIDAD', '2');
define('FDXFACTOR', '3'); 

define('AG_FDX','1');
define('AG_DHL','2');

define('OTROS', '1');
define('COLOMBIA', '2');

define('MP_KHIPU', '1');
define('MP_BANCHILE', '2');
define('MP_ADMIN', '3');

define('P_PENDING', '0');
define('P_CONFIRM', '1');
define('P_CANCEL', '2');
define('P_VALKHIPU', '3');

define('ACT_INSERT', 'ins');
define('ACT_UPDATE', 'upd');
define('ACT_DELETE', 'del');

define('MONEDA', 'CLP');

define('COMISION_KP', '800');
define('COMISION_AP', '1');

define('PAISEMISION', '1');

define('TB_OCUP','OCUPACION');
define('TB_BENE','BENEFICIARIO');
define('TB_ORIF','ORIFONDOS');
define('TB_POEMP','POSIEMPLEO');
define('TB_MOTTRA','MOTTRANSAC');

define('PS_TURBOSMTP','XXXoce4346');

define('RECEIVERID', '266149'); // Desarrollo: 300604 - PROD: 266149
define('SECRETKEY', 'be98aac933dedbeb6f437254d1def1dc23e1dba3'); // Desarrollo: c5b48749c913c1efc1652089487318b1f632037e / PROD: be98aac933dedbeb6f437254d1def1dc23e1dba3

define('SOPORTE','soporte@astropaycard.cl'); //soporte@astropaycard.cl
define('USU_ADMIN', '1190'); // PRUEBAS ID: 632
define('TPT_IMG', '1');
define('TPT_EXC', '2');

define('TWL_SID', '');
define('TWL_TKN', '');
define('TWL_NUM', '');
