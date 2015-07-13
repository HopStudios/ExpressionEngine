<?php

namespace EllisLab\ExpressionEngine\Service\Thumbnail;

use EllisLab\ExpressionEngine\Model\File\File;
use InvalidArgumentException;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		https://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine Thumbnail Class
 *
 * @package		ExpressionEngine
 * @category	Service
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class Thumbnail {

	/**
	 * @var str The url to the thumbnail
	 */
	protected $url;

	/**
	 * @var str The path to the thumbnail
	 */
	protected $path;

	/**
	 * Constructor: sets the url and path properties based on the arguments
	 *
	 * @param File $file (optional) A File entity from which we'll calculate the
	 *   thumbnail url and path.
	 */
	public function __construct(File $file = NULL)
	{
		$this->setDefault();

		if ($file)
		{
			if ( ! $file->exists())
			{
				$this->setMissing();
			}
			elseif ($file->isImage())
			{
				$this->url = rtrim($file->getUploadDestination()->url, '/') . '/_thumbs/' . $file->file_name;
				$this->path = rtrim($file->getUploadDestination()->server_path, '/') . '/_thumbs/' . $file->file_name;
			}
		}
	}

	public function __get($name)
	{
		if ( ! property_exists($this, $name))
		{
			throw new InvalidArgumentException("No such property: '{$name}' on ".get_called_class());
		}

		return $this->$name;
	}

	/**
	 * Sets the url and path properties to the default image
	 *
	 * @return void
	 */
	public function setDefault()
	{
		$this->url = PATH_CP_GBL_IMG . 'default.png';
		$this->path = PATH_THEMES . 'cp_global_images/default.png';
	}

	/**
	 * Sets the url and path properties to the missing image
	 *
	 * @return void
	 */
	public function setMissing()
	{
		$this->url = PATH_CP_GBL_IMG . 'missing.jpg';
		$this->path = PATH_THEMES . 'cp_global_images/missing.jpg';
	}

	/**
	 * Determines if the file exists
	 *
	 * @return bool TRUE if it does FALSE otherwise
	 */
	public function exists()
	{
		return file_exists($this->path);
	}

	/**
	 * Determines if the file is writable
	 *
	 * @return bool TRUE if it is FALSE otherwise
	 */
	public function isWritable()
	{
		return is_writable($this->path);
	}

}
// EOF