
<?php
/**
 * @package     Joomla.Administrator
* @subpackage  com_finances
*
* @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Form Rule class to ensure amount is a number.
 */
class JFormRuleAmount extends JFormRule
{
	/**
	 * The regular expression.
	 *
	 * @access	protected
	 * @var		string
	 * @since	2.5
	 */
	protected $regex = '^[1-9]\d*(\.\d+)?$';
}