<?php
/**
 * ImproDev_EmailManager Edit Form Admin Block.
 * @package     ImproDev_EmailManager
 * @author      ImproDev
 *
 */
namespace ImproDev\EmailManager\Block\Adminhtml\Grid\Edit;


/**
 * Adminhtml Edit Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create([
            'data' => [
                'id' => 'edit_form',
                'method' => 'post',
                'action' => $this->getData('action'),
            ],
        ]);
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}