<?php
/** @noinspection PhpUnused */
namespace hexlet;

require_once realpath( dirname( __FILE__ ) ) . '/MYDB.php';
require_once realpath( dirname( __FILE__ ) ) . '/JsonHelper.php';


class DBSelector {


    /**
     * @var array of string , these are the allowed values to pass to
     * @see DBSelector::getConnection()
     */
    protected static $db_names = [
    	'hexlet',
        'ignore'
    ];
    protected static $cache = [];

    //returns stored connection, may created it first

    /**
     * Gets the database connection for the connection
     * @param string $what <p>
     *   @see MYDB::getMySqliDatabase() for details of keys in the array used in the code
     * @uses DBSelector::$db_names
     *
     * @return object|MYDB
     * @throws SQLException
     *
     */
    public static function getConnection($what = 'hexlet') {
        if (isset(self::$cache[$what])) {
            $mysqli =  self::$cache[$what]->getDBHandle();
            return new MYDB($mysqli); //smart pointer, db will only go out of scope when the static class def does
        }

        if (in_array($what, self::$db_names)) {
            switch ($what) {
                case 'ignore': {
                    $mydb = null;
                    break;
                }
                case 'hexlet':
	                $dbstuff = [
		                'username'      => $_ENV['GK_MYSQL_USER'],
		                'password'      => $_ENV['GK_MYSQL_PASSWORD'],
		                'database_name' => $_ENV['GK_MYSQL_DATABASE'],
		                'host'          => $_ENV['GK_MYSQL_HOST'],
		                'character_set' => $_ENV['DB_MYSQL_CHARSET'],
		                'port'          => $_ENV['GK_MYSQL_PORT']
	                ];
                    $mydb = new MYDB(null,$dbstuff,true);
                    break;

                default:
                    throw new SQLException("Cannot create new db connection from name of [$what]");
            }
        } else {
            throw new SQLException("Error creating new db connection from name of [$what]");
        }

        self::$cache[$what] = $mydb;
        return $mydb;
    }




}