<?php

namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

//use ImproDev\EmailManager\Controller\Adminhtml\Grid;
//use Magento\Framework\Controller\ResultFactory;

/**
 * New block action.
 */
class NewAction extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
