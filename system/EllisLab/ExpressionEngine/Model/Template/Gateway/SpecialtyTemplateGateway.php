<?php
namespace EllisLab\ExpressionEngine\Model\Template\Gateway;

use EllisLab\ExpressionEngine\Service\Model\Gateway;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine Specialty Template Table
 *
 * @package		ExpressionEngine
 * @subpackage	Template\Gateway
 * @category	Model
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class SpecialtyTemplateGateway extends Gateway {

	protected static $_table_name = 'specialty_templates';
	protected static $_primary_key = 'template_id';

	protected $template_id;
	protected $site_id;
	protected $enable_template;
	protected $template_name;
	protected $data_title;
	protected $template_data;

}
