<?php

namespace ImproDev\EmailManager\Controller\Adminhtml\Block;

use ImproDev\EmailManager\Api\BlockRepositoryInterface;
use ImproDev\EmailManager\Controller\Adminhtml\Grid as EmailManagerGrid;
use Magento\Framework\View\LayoutFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;

/**
 * BlockItems grid action.
 */
class Grid extends EmailManagerGrid
{
    /**
     * @var BlockRepositoryInterface
     */
    protected $_blockRepository;

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var LayoutFactory
     */
    protected $_layoutFactory;

    /**
     * Grid constructor.
     *
     * @param BlockRepositoryInterface $blockRepository
     * @param Registry                 $coreRegistry
     * @param LayoutFactory            $layoutFactory
     * @param Action\Context           $context
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        Registry $coreRegistry,
        LayoutFactory $layoutFactory,
        Action\Context $context
    )
    {
        $this->_blockRepository = $blockRepository;
        $this->_coreRegistry = $coreRegistry;
        $this->_layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('block_id');

        try {
            $block = $this->_blockRepository->getById($id);
            $this->_coreRegistry->register('row_data', $block);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('404: block not found.'));

            /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }

        $layout = $this->_layoutFactory->create();
        $block = $layout->createBlock('ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab\Item', 'item_table');

        /** @var \Magento\Framework\Controller\Result\Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($block->toHtml());

        return $result;
    }
}
