<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_lockers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 *
 * @since  0.0.1
 */
class JFormFieldMembers extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Members';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('MemberID,concat(membersurname,", ",memberfirstname) as membername, memberfirstname, membersurname');
		$query->from('members as m');  
        
        $query->order('membersurname ASC'); // sort by firstname, then surname
        $query->order('memberfirstname ASC'); // sort by firstname, then surname
        //$app = JFactory::getApplication ();
        //$app->enqueueMessage('Query = '.$query.';');
        $db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->MemberID, $message->membername);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}