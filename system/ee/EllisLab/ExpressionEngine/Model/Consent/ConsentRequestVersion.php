<?php
/**
 * ExpressionEngine (https://expressionengine.com)
 *
 * @link      https://expressionengine.com/
 * @copyright Copyright (c) 2003-2018, EllisLab, Inc. (https://ellislab.com)
 * @license   https://expressionengine.com/license
 */

namespace EllisLab\ExpressionEngine\Model\Consent;

use EllisLab\ExpressionEngine\Service\Model\Model;

/**
 * Consent Request Version Model
 */
class ConsentRequestVersion extends Model {

	protected static $_primary_key = 'consent_request_version_id';
	protected static $_table_name = 'consent_request_versions';

	protected static $_typed_columns = [
		'consent_request_version_id' => 'int',
		'consent_request_id'         => 'int',
		'create_date'                => 'timestamp',
		'author_id'                  => 'int',
		'edit_date'                  => 'timestamp',
		'last_author_id'             => 'int',
	];

	protected static $_relationships = [
		'ConsentRequest' => [
			'type' => 'belongsTo',
		],
		'Consents' => [
			'type' => 'hasMany',
		],
		'Author' => [
			'type' => 'belongsTo',
			'model' => 'Member',
			'from_key' => 'author_id',
			'weak' => TRUE
		],
		'LastAuthor' => [
			'type' => 'belongsTo',
			'model' => 'Member',
			'from_key' => 'last_author_id',
			'weak' => TRUE
		],
	];

	protected static $_validation_rules = [
		'create_date'    => 'required',
		'author_id'      => 'required',
		'edit_date'      => 'required',
		'last_author_id' => 'required',
	];

	// protected static $_events = [];

	// Properties
	protected $consent_request_version_id;
	protected $consent_request_id;
	protected $request;
	protected $request_format;
	protected $create_date;
	protected $author_id;
	protected $edit_date;
	protected $last_author_id;

}

// EOF
