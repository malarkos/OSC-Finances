<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_locker
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Finances Controller
 *
 * @since  0.0.1
 */
class FinancesControllerFinances extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Finances', $prefix = 'FinancesModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	public function csvReport() {
		
	}
	
	public function delete() {
		/*$application = JFactory::getApplication();
		 $application->enqueueMessage('In remove.');*/
		$model = $this->getModel('FinanceEntry');
		if ($model->delete())
		{
			$returnurl = 'index.php?option=com_finances';
			
			$this->setRedirect($returnurl);
		}
	}
}