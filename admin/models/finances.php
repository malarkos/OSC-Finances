<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * LockersList Model
 *
 * @since  0.0.1
 */
class FinancesModelFinances extends JModelList
{
        	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id','f.id',
				'MemberID','f.MemberID',
				'MemberFirstname','m.MemberFirstname',
				'MemberSurname','m.MemberSurname'
			);
		}
 
		parent::__construct($config);
	}
       
	
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
	
		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	
		$limit = 1000;  // set list limit
	
		$this->setState('list.limit', $limit);
		
		// set filters
		$value = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $value);
		
		$member = $app->getUserStateFromRequest($this->context . 'filter.member', 'filter_member', '', 'string');
		$this->setState('filter.member', $member);
		
		parent::populateState('f.TransactionDate', 'asc');
	}
        
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// get input
		/*$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );*/
 
		// Create the base select statement.
		$query->select('f.*,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername');               
                $query->from('finances AS f');  // use new osclockers table
                $query->where('f.MemberID > 0');
                $query->leftJoin('members AS m ON f.MemberID = m.MemberID'); // Use new member table
                
                		// Filter: like / search
		$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
			
			$query->where('((m.MemberFirstname LIKE ' . $search . ') OR (m.MemberSurname LIKE ' . $search . ')) ');
		}
 
		// if have a member id in the request, filter on that.
		// Removed functionality as now have filter working for this
		/*if($memid <> 0)
		{
			$query->where('f.MemberID = '.$memid);
		}*/
 
		// Filter by member
		$member = $this->getState('filter.member');
		if (is_numeric($member))
		{
			$query->where('f.MemberID = '.(int) $member);
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering','f.TransactionDate');
		$orderDirn 	= $this->state->get('list.direction','asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
 
		return $query;
	}
	
	/*
	 * Function to return finance entries - first gets a list of the members through the filters, then cycles through each entry by date and adds the total field
	 */
	public function getFinanceEntries()
	{
		// get input
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		// get information
		// get all distinct memberids in finances
		// cycle through all finance entries by memberid
		// add a "total" field to the array
		// return array
		
	}
	
	public function getMemberDetails(){
	    
	    
	    
	    // if there is a member, return the membername
	    $member = $this->getState('filter.member');
	    if (is_numeric($member) && $member > 0)
	    {
	        $db    = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        // Create the base select statement.
	        $query->select('concat(MemberFirstname,\' \',MemberSurname) as membername');
	        $query->from('members');  // use new osclockers table
	        $query->where('MemberID = '.(int) $member);
	        
	        $db->setQuery ( $query );
	        $memberdetails = $db->loadResult();
	        
	        return ($memberdetails);
	        
	    }
	}
	
	public function getCurrentBalance() {
	    return 0;
	}
}