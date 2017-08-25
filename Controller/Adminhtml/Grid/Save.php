<?php

namespace ImproDev\EmailManager\Controller\Adminhtml\Grid;

use ImproDev\EmailManager\Api\BlockRepositoryInterface;
use ImproDev\EmailManager\Controller\Adminhtml\Grid;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Backend\App\Action;

/**
 * Class Save.
 */
class Save extends Grid
{

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = 'contact/email/sender_email_identity';

    /**
     * @var BlockRepositoryInterface
     */
    protected $_blockRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;


    /**
     * Save constructor.
     *
     * @param BlockRepositoryInterface $blockRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param Action\Context           $context
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        ScopeConfigInterface $scopeConfig,
        Action\Context $context
    ) {
        $this->_blockRepository = $blockRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $model = $this->_initModel();

            // If Reply, send message and set status "Replied"
            if(isset($data['reply'])) {
                $data['status'] = 1;
                $model->addData($data);
                $this->_sendMessage($model);
                $this->messageManager->addSuccessMessage(__('Email has been successfully sent.'));
            }

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

    protected function _sendMessage($model)
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $receiverInfo = [
            'name' => $model->getData('name'),
            'email' => $model->getData('email')
        ];

        $senderInfo = [
            'name' => 'Smile',
            'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope)
        ];

        $emailTemplateVars = [
            'name'    => $model->getData('name'),
            'subject' => $model->getData('subject'),
            'message' => $model->getData('reply_message')
        ];

        $this->_objectManager
            ->get('ImproDev\EmailManager\Helper\Email')
            ->sendMail($emailTemplateVars, $senderInfo, $receiverInfo);

    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ImproDev_EmailManager::email_manager');
    }
}
