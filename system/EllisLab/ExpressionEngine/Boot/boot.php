<?php  if ( ! defined('SYSPATH')) exit('No direct script access allowed');
/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0.0
 * @filesource
 */

/*
 * ------------------------------------------------------
 *  Set and load the framework constants
 * ------------------------------------------------------
 */
	// Path to the legacy app folder. Most legacy files
	// check for this at the top, so it's hard to remove

	define('BASEPATH', SYSPATH.'/expressionengine/');

	require(BASEPATH.'config/constants.php');

/*
 * ------------------------------------------------------
 *  Load the autoloader and register it
 * ------------------------------------------------------
 */
	require(SYSPATH.'EllisLab/ExpressionEngine/Service/Autoloader.php');

	EllisLab\ExpressionEngine\Service\Autoloader::getInstance()->register();


/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
	require(__DIR__.'/boot.common.php');

/*
 * ------------------------------------------------------
 *  Check for the installer if we're booting the CP
 * ------------------------------------------------------
 */
	if (FALSE && is_dir($system_path.'installer/'))
	{
		define('APPPATH', SYSPATH.'installer/');
		define('EE_APPPATH', BASEPATH);

		get_config(array('subclass_prefix' => 'Installer_'));
	}
	else
	{
		define('APPPATH', BASEPATH);

		get_config(array('subclass_prefix' => 'EE_'));
	}

/*
 * ------------------------------------------------------
 *  Define a custom error handler so we can log PHP errors
 * ------------------------------------------------------
 */
	set_error_handler('_exception_handler');

/*
 * ------------------------------------------------------
 *  Set mandatory config overrides
 * ------------------------------------------------------
 */

	get_config(array(
		'directory_trigger'  => 'D',
		'controller_trigger' => 'C',
		'function_trigger'   => 'M'
	));

/*
 * ------------------------------------------------------
 *  Set a liberal script execution time limit
 * ------------------------------------------------------
 */
	if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
	{
		@set_time_limit(300);
	}

/*
 * ------------------------------------------------------
 *  Start the timer... tick tock tick tock...
 * ------------------------------------------------------
 */
	$BM =& load_class('Benchmark', 'core');
	$BM->mark('total_execution_time_start');
	$BM->mark('loading_time:_base_classes_start');


/*
 * ------------------------------------------------------
 *  Instantiate the config class
 * ------------------------------------------------------
 */
	$CFG =& load_class('Config', 'core');

	// Do we have any manually set config items in the index.php file?
	if (isset($assign_to_config))
	{
		$CFG->_assign_to_config($assign_to_config);
	}

/*
 * ------------------------------------------------------
 *  Instantiate the UTF-8 class
 * ------------------------------------------------------
 *
 * Note: Order here is rather important as the UTF-8
 * class needs to be used very early on, but it cannot
 * properly determine if UTf-8 can be supported until
 * after the Config class is instantiated.
 *
 */

	$UNI =& load_class('Utf8', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the URI class
 * ------------------------------------------------------
 */
	$URI =& load_class('URI', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the routing class and set the routing
 * ------------------------------------------------------
 */
	$RTR =& load_class('Router', 'core');
	$RTR->_set_routing();

	// Set any routing overrides that may exist in the main index file
	if (isset($routing))
	{
		$RTR->_set_overrides($routing);
	}

/*
 * ------------------------------------------------------
 *  Instantiate the output class
 * ------------------------------------------------------
 */
	$OUT =& load_class('Output', 'core');

/*
 * -----------------------------------------------------
 * Load the security class for xss and csrf support
 * -----------------------------------------------------
 */
	$SEC =& load_class('Security', 'core');

/*
 * ------------------------------------------------------
 *  Load the Input class and sanitize globals
 * ------------------------------------------------------
 */
	$IN	=& load_class('Input', 'core');

/*
 * ------------------------------------------------------
 *  Load the Language class
 * ------------------------------------------------------
 */
	$LANG =& load_class('Lang', 'core');


/*
 * ------------------------------------------------------
 *  Alias CI_ prefixed stuff we used to have in case
 *  someone type hints. Definitely don't rely on this
 *  staying here for terribly long.
 *
 *  These were consolidated with the old EE libraries to
 *  reduce dead weight.
 *  Done again in the loader, but we do it here for the
 *  above core classes.
 * ------------------------------------------------------
 */
	class_alias('EE_Benchmark', 'CI_Benchmark');
	class_alias('EE_Config', 'CI_Config');
	class_alias('EE_Input', 'CI_Input');
	class_alias('EE_Lang', 'CI_Lang');
	class_alias('EE_Output', 'CI_Output');
	class_alias('EE_URI', 'CI_URI');
	class_alias('EE_Utf8', 'CI_Utf8');
	class_alias('EE_Router', 'CI_Router');
	class_alias('EE_Security', 'CI_Security');
	// do these at the bottom of their respective files?
	//class_alias('EE_Exceptions', 'CI_Exceptions');


/*
 * ------------------------------------------------------
 *  Load the app controller and local controller
 * ------------------------------------------------------
 *
 */
	// Load the base controller class
	require APPPATH.'core/Controller.php';

	function &get_instance()
	{
		return CI_Controller::get_instance();
	}


	function ee($dep = NULL)
	{
		static $EE;
		if ( ! $EE) $EE = get_instance();

		if (isset($dep) && isset($EE->di))
		{
			return $EE->di->make($dep);
		}

		return $EE;
	}


	if (file_exists(APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php'))
	{
		require APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php';
	}

	// Load the local application controller
	// Note: The Router class automatically validates the controller path using the router->_validate_request().
	// If this include fails it means that the default controller in the Routes.php file is not resolving to something valid.
	if ( ! file_exists(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php'))
	{
		show_error('Unable to load your default controller. Please make sure the controller specified in your Routes.php file is valid.');
	}

	include(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php');

	// Set a mark point for benchmarking
	$BM->mark('loading_time:_base_classes_end');

/*
 * ------------------------------------------------------
 *  Security check
 * ------------------------------------------------------
 *
 *  None of the functions in the app controller or the
 *  loader class can be called via the URI, nor can
 *  controller functions that begin with an underscore
 */
	$class  = $RTR->fetch_class();
	$method = $RTR->fetch_method();

	if ( ! class_exists($class)
		OR strncmp($method, '_', 1) == 0
		OR in_array(strtolower($method), array_map('strtolower', get_class_methods('CI_Controller')))
		)
	{
		show_404("{$class}/{$method}");
	}

/*
 * ------------------------------------------------------
 *  Instantiate the requested controller
 * ------------------------------------------------------
 */
	// Mark a start point so we can benchmark the controller
	$BM->mark('controller_execution_time_( '.$class.' / '.$method.' )_start');

	$CI = new $class();

/*
 * ------------------------------------------------------
 *  Call the requested method
 * ------------------------------------------------------
 */
	// Is there a "remap" function? If so, we call it instead
	if (method_exists($CI, '_remap'))
	{
		$CI->_remap($method, array_slice($URI->rsegments, 2));
	}
	else
	{
		// is_callable() returns TRUE on some versions of PHP 5 for private and protected
		// methods, so we'll use this workaround for consistent behavior
		if ( ! in_array(strtolower($method), array_map('strtolower', get_class_methods($CI))))
		{
			show_404("{$class}/{$method}");
		}
		try {
			// Call the requested method.
			// Any URI segments present (besides the class/function) will be passed to the method for convenience
			call_user_func_array(array(&$CI, $method), array_slice($URI->rsegments, 2));
		}
		catch(Exception $ex)
		{
			echo '<div>
					<h1>Exception Caught</h1>
					<p><strong>' . $ex->getMessage() . '</strong></p>
					<p><em>'  . $ex->getFile() . ':' . $ex->getLine() . '<em></p>
					<p>Stack Trace:
						<pre>' . str_replace('#', "\n#", str_replace(':', ":\n\t\t", $ex->getTraceAsString())) . '</pre>
					</p>
				</div>';
			die('Fatal Error.');
		}

	}


	// Mark a benchmark end point
	$BM->mark('controller_execution_time_( '.$class.' / '.$method.' )_end');


/*
 * ------------------------------------------------------
 *  Send the final rendered output to the browser
 * ------------------------------------------------------
 */
	$OUT->_display();

/*
 * ------------------------------------------------------
 *  Close the DB connection if one exists
 * ------------------------------------------------------
 */
	if (class_exists('CI_DB') AND isset($CI->db))
	{
		$CI->db->close();
	}


/* End of file CodeIgniter.php */
/* Location: ./system/core/CodeIgniter.php */
