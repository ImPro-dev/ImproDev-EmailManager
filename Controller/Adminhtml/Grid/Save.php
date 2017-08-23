<?php

namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

use ImproDev\EmailManager\Api\BlockRepositoryInterface;
use ImproDev\EmailManager\Controller\Adminhtml\Grid;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;

/**
 * Class Save.
 */
class Save extends Grid
{
    /**
     * @var BlockRepositoryInterface
     */
    protected $_blockRepository;

    /**
     * Save constructor.
     *
     * @param BlockRepositoryInterface $blockRepository
     * @param Action\Context           $context
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        Action\Context $context
    ) {
        $this->_blockRepository = $blockRepository;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        // If Reply, send message and set status "Replied"
        if($data && isset($data['reply'])) {
            $this->_sendMessage();
            $data['status'] = 1;
        }

        if ($data) {
            $model = $this->_initModel();
            $model->addData($data);

            try {
                $this->_blockRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Email data has been successfully saved.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }
            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        }

        return $resultRedirect->setPath('*/*');
    }

    /**
     * Init model
     *
     * @param int|null $id
     *
     * @return \ImproDev\EmailManager\Api\Data\GridInterface
     */
    protected function _initModel($id = null)
    {
        $id = $id ?: $this->getRequest()->getParam('id');

        return $id
            ? $this->_blockRepository->getById($id)
            : $this->_blockRepository->getModelInstance();
    }

    protected function _sendMessage()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ImproDev_EmailManager::email_manager');
    }
}
