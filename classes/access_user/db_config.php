<?php 
// use this pathes and/or define the pathes for the "standard" pages
define("CLASS_PATH", dirname($_SERVER['PHP_SELF'])."/"); // the location where the class is executed
$sec_path = "/classes/access_user/"; // a second location where the scripts should be 
define("APPLICATION_PATH", $sec_path);

// modify these constants to fit your environment
define("DB_SERVER", "localhost");
define("DB_NAME", "i561957_development");
define ("DB_USER", "i561957_IIUser");
define ("DB_PASSWORD", "Gingerman1");

// these are the names for the standard table names
// !!! Important
// It's possible that your server doesn't allow the database name inside a query
// if this forms a problem don't use them here and unescape the mysql_select_db() function
// inside the connect_db() method.
define("USER_TABLE", DB_NAME.".users"); 
define("PROFILE_TABLE", DB_NAME.".users_profile");
define("COUNTRY_TABLE", DB_NAME.".countries"); // an optional table with countruy names and codes

// variables (locations) standard pages (combine the pathes from the top or use your own)
//define("LOGIN_PAGE", CLASS_PATH."login.php");
define("LOGIN_PAGE", CLASS_PATH."");
define("START_PAGE", CLASS_PATH."publish");	//example.php");
//define("ACTIVE_PASS_PAGE", APPLICATION_PATH."activate_password.php");
define("ACTIVE_PASS_PAGE", "/login.php");
define("DENY_ACCESS_PAGE", APPLICATION_PATH."deny_access.php");
define("ADMIN_PAGE", APPLICATION_PATH."admin_user.php");
// your path must be related to the site root.
/*
 * 
echo "Login Page = ".LOGIN_PAGE.'<br>';
echo "Start Page = ".START_PAGE.'<br>';
echo "Application path = ".APPLICATION_PATH.'<br>';
echo "Class Path = ".CLASS_PATH.'<br>';
die;*/
 
// change this constants to the right mail settings
define("WEBMASTER_MAIL", "administrator@irishinterest.ie"); 
define("WEBMASTER_NAME", "Irish Interest Administrator"); 
define("ADMIN_MAIL", "administrator@irishinterest.ie"); 
define("ADMIN_NAME", "Irish Interest Administrator"); 

// change this vars if you need...
define("PW_LENGTH", 4);
define("LOGIN_LENGTH", 0);

define("COOKIE_NAME", "user"); 
//define("COOKIE_PATH", APPLICATION_PATH);
define("COOKIE_PATH", "");
define("MIN_ACCESS_LEVEL", 1);
define("MAX_ACCESS_LEVEL", 10);
define("DEFAULT_ACCESS_LEVEL", 1);
define("DEFAULT_ADMIN_LEVEL", 10);

//////////////////////////////////////////////////
// constants and field names user profile table //
/////////////////////////////////////////////// //
// stamdard fields are: address, postcode, city, country, phone, fax, homepage, textfield
// variables must match your user profile table design
// use this four user defined fields (type varchar(100) too
// change the value of a constant but change them in the mysql table too
// otherwise you wil get some ERROR'S !!!
define("TBL_USERFIELD_1", "user_1");
define("TBL_USERFIELD_2", "user_2");
define("TBL_USERFIELD_3", "user_3");
define("TBL_USERFIELD_4", "user_4");

?>