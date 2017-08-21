<?php

namespace ImproDev\EmailManager\Block\Adminhtml\Grid\Edit;

use Magento\Backend\Block\Widget\Tabs as BaseTabs;

/**
 * Tabs
 *
 * @package ImproDev\EmailManager\Block\Adminhtml\Grid\Edit
 */
class Tabs extends BaseTabs
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('email_manager_block_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Email Details');
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'main_section',
            [
                'label' => __('Received Email'),
                'title' => __('Received Email'),
                'content' => $this->getLayout()->createBlock(
                    'ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab\General'
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'reply_section',
            [
                'label' => __('Reply to Email'),
                'title' => __('Reply to Email'),
                'content' => $this->getLayout()->createBlock(
                    'ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab\Reply',
                    'reply.email'
                )->toHtml()
            ]
        );
        return parent::_beforeToHtml();
    }
}
