<?php

/*
 * Initializes the library, other files can include this file and do something
 */
namespace hexlet;


require_once 'constants.php';

require_once HEXLET_LIB_VENDOR . '/autoload.php';


require_once HEXLET_LIB_INCLUDES . '/will-lib/base_exeption.php';
require_once HEXLET_LIB_INCLUDES . '/will-lib/Settings.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/JsonHelper.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/RecursiveClasses.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/MYDB.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/LibCon.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/Input.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/GitHelper.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/DBSelector.php';
require_once HEXLET_LIB_INCLUDES. '/will-lib/CurlHelper.php';
# Settings::build_settings();