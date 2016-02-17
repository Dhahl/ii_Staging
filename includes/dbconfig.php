<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Class configuration for the database.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Dbconfig {
    public $driver = 'mysql';
    public $dbhost = 'localhost';
    public $dbuser = 'admin';
    public $dbpass = '';
    public $dbname = 'dev_irishinterest';
   // public $prefix = 'pfx_';
	 public $prefix = '';
}