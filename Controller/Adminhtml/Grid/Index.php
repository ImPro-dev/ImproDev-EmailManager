<?php

namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

class Index extends \Magento\Backend\App\Action
{
    const ACL_RESOURCE = 'ImproDev_EmailManager::email_manager';
    const MENU_ITEM = 'ImproDev_EmailManager::email_manager';
    const TITLE = 'Email Manager';

    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(self::ACL_RESOURCE);
        return $result;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(self::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend(__(self::TITLE));
        return $resultPage;
    }
}