<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_lockers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->filter_order);
$listDirn = $this->escape($this->filter_order_Dir);
$total = 0;
?>
<form action="index.php?option=com_finances&view=finances" method="post"
	id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_FINANCES_FILTER'); ?>
			<?php
echo JLayoutHelper::render('joomla.searchtools.default', array(
    'view' => $this
));
?>
		</div>
	</div>
	
	<h2>Finances for: <?php echo $this->memberdetails; ?> </h2>
	Current balance: $<?php echo $this->currentbalance; ?>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="1%"><?php echo JText::_('COM_FINANCES_NUM'); ?></th>
				<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			
			
				
				
				
				<th width="20%">
				<?php echo JText::_('COM_FINANCES_MEMBER') ;?>
				</th>
				<th width="10%">
				<?php echo JHtml::_('grid.sort', 'COM_FINANCES_TRANSACTIONDATE', 'f.TransactionDate', $listDirn, $listOrder); ?>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_FINANCES_CREDITDEBIT') ;?>
			</th>
				<th width="10%">
				<?php echo JText::_('COM_FINANCES_AMOUNT') ;?>
			</th>
				<th width="10%">
				<?php echo JText::_('COM_FINANCES_TOTAL') ;?>
			</th>
				<th width="20%">
				<?php echo JText::_('COM_FINANCES_DESCRIPTION') ;?>
				</th>
				<th width="20%">
				<?php echo JText::_('COM_FINANCES_COMMENT') ;?>
				</th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php $totalamount=0;?>
			<?php if (!empty($this->items)) : ?>
				<?php

    foreach ($this->items as $i => $row) :
        $link = JRoute::_('index.php?option=com_finances&task=financeentry.edit&FinanceID=' . $row->FinanceID);
        // $link = JRoute::_ ( 'index.php?option=com_finances&task=financeentry.edit&FinanceID=' . $row->id . '&memid=' . $row->MemberID );
        ?>
 
					<tr>
				<td><?php echo $this->pagination->getRowOffset($i); ?></td>
				<td>
							<?php echo JHtml::_('grid.id', $i, $row->FinanceID); ?>
						</td>
				<td>
						
								<?php echo $row->membername; ?>
							
						</td>
				<td>
							
                          <?php echo $row->TransactionDate; ?>
                                                        
						</td>
				<td>
						
								<?php echo $row->CreditDebit; ?>
							
						</td>


				<td><a href="<?php echo $link; ?>">
                               $<?php echo $row->Amount; $total += $row->Amount;?>
                           </a></td>
				<td>
                                                       $<?php $totalamount = money_format('%.2n', $total); /*sprintf("%04.2f",$total); */ echo $totalamount;?>
                                                       </td>
				<td>
                                                        <?php echo $row->Description; ?>
						</td>
				<td>
                                                        <?php echo $row->Comment; ?>
						</td>


			</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value="" /> <input type="hidden"
		name="boxchecked" value="0" /> <input type="hidden"
		name="filter_order" value="<?php echo $listOrder; ?>" /> <input
		type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>