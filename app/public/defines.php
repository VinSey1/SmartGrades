<?php

define('DS', DIRECTORY_SEPARATOR);

define('DIR', basename(dirname(__FILE__)));

define('ROOT', dirname('.'));

define('VIEWS', ROOT.DS.'views');
define('COMMON', VIEWS.DS.'common');

define('ORM', ROOT.DS.'orm');

define('ASSETS', ROOT.DS.'assets');
define('CSS', ASSETS.DS.'css');
define('FILES', ASSETS.DS.'files');

define('CLASSES', ROOT.DS.'classes');
define('M_CLASSES', CLASSES.DS.'model');
define('V_CLASSES', CLASSES.DS.'view');
define('C_CLASSES', CLASSES.DS.'controller');

define('LIBS', ASSETS.DS.'libs');
define('PHP_MAILER', LIBS.DS.'PHP_MAILER');

?>