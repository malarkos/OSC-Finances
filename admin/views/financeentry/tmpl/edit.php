<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_finances
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access
defined('_JEXEC') or die('Restricted access');


// form validation
JHtml::_('behavior.formvalidator');


// enable validation
JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'financeentry.cancel' || document.formvalidator.isValid(document.getElementById('financeentry-form'))) {
			Joomla.submitform(task, document.getElementById('financeentry-form'));
		}
	};
");
JFactory::getDocument()->addScriptDeclaration("
document.formvalidator.setHandler('datetime', function(value, element) {
	var regex = /^(\d{4})(\/|\-)(\d{1,2})(\/|\-)(\d{1,2})\s(\d{1,2})(\/|\:)(\d{1,2})(\/|\:)(\d{1,2})$/;
	return regex.test(value);

	});
");
?>



<form action="<?php echo JRoute::_('index.php?option=com_finances&layout=edit&FinanceID=' . (int) $this->item->FinanceID); ?>"
    method="post" name="adminForm" id="financeentry-form" class="form-validate">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_FINANCE_ENTRY_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="financeentry.edit" />
    
    <?php echo JHtml::_('form.token'); ?>
</form>