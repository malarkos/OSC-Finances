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
 
/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class FinancesModelFinanceEntry extends JModelAdmin
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'FinanceEntry', $prefix = 'FinancesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_finances.financeentry',
			'financeentry',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
 
		if (empty($form))
		{
			return false;
		}
 
		return $form;
	}
 
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_finances.edit.financeentry.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}
	
	protected function prepareTable($table)
	{
		$dt = new DateTime();
		$dt->format('Y-m-d H:i:s');
		$table->lastmodified = $dt;  // Set last modified time
		$table->AmountNoGST = $table->Amount * 10 /11; // set no GST amount
		$table->GST = $table->Amount / 11; // set GST
		// values need to be negative if a Debit
		if ($table->CreditDebit === "D" && $table->Amount > 0) { // only check if not already negative
			$table->Amount = $table->Amount * -1;
			$table->AmountNoGST = $table->AmountNoGST * -1;
			$table->GST = $table->GST * -1;
		}
		
		//$table->FinanceID = $table->id; // TODO check what happens for a new entry?
		
		// save Member id to session variable
		$session = JFactory::getSession();
		$session->set( 'memid', $table->MemberID );
	}
	
	protected function postSaveHook($model, $validData) {
		$item = $model->getItem();
		$itemid = $item->get('FinanceID');
		
		//TODO update FinanceID after save
	}
	
	/*
	 * Function to "delete" entry by setting OldMember ID to MemberID and MemberID to 0.
	 */
	
	function delete() {
		$db = JFactory::getDbo ();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable();
		if (count( $cids )) {
			foreach($cids as $cid) {
				
				
				$query = $db->getQuery ( true );
				$query->select ( 'MemberID' );
				$query->from ( 'finances' );
				$query->where ( 'FinanceID = ' . $cid );
				
				$db->setQuery ( $query );
				$db->execute ();
				
				try
				{
					$memberid = $db->loadResult ();
				}
				catch (Exception $e)
				{
					// Render the error message from the Exception object
					JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
					return false;
				}
				// cid = rowid
				// Load memberid
				// set old memberid = member id
				// set memberid = 0
				$query = $db->getQuery ( true );
				$fields = array('MemberID =  0',
		
						'OldMemberID = '. $memberid
				);
				$conditions = array('FinanceID = ' . $cid);
				$query->update('finances');
				$query->set($fields);
				$query->where($conditions);
				
				$db->setQuery ( $query );
				$db->execute ();
				
				//$msg = "Removing this cid:".$cid." for this member:".$memberid.":";
				
				 $application = JFactory::getApplication();
				 $application->enqueueMessage($msg);
				
			}
		}
		return true;
	}
	
}