<?php

namespace ImproDev\EmailManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Abstract Parallax Block Action.
 */
abstract class Grid extends Action
{
    /**
     * Init action metadata.
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $result
            ->setActiveMenu('ImproDev_EmailManager::email_manager')
            ->addBreadcrumb(__('Email Manager'), __('Email Manager'))
            ->addBreadcrumb(__('Manage Emails'), __('Manage Emails'))
            ->getConfig()->getTitle()->prepend(__('Manage Emails'))
        ;

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ImproDev_EmailManager::email_manager');
    }
}
