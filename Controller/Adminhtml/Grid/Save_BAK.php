<?php
/**
 * ImproDev_EmailManager Save Controller.
 * @package     ImproDev_EmailManager
 * @author      ImproDev
 *
 */
namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('emailmanager/grid/edit');
            return;
        }
        try {
            $rowData = $this->_objectManager->create('ImproDev\EmailManager\Model\Grid');
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        $this->_redirect('emailmanager/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ImproDev_EmailManager::email_manager');
    }
}