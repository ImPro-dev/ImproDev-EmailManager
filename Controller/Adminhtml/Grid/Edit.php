<?php
/**
 * ImproDev_EmailManager Edit Form Admin Block.
 * @package     ImproDev_EmailManager
 * @author      ImproDev
 *
 */
namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry    $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
    }
    /**
     * Add New Row Form page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->_objectManager->create('ImproDev\EmailManager\Model\Grid');
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            if (!$rowData->getEntityId()) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('emailmanager/grid/index');
                return;
            }
        }

        $this->_coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = __('Email Information ');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ImproDev_EmailManager::edit_row');
    }
}