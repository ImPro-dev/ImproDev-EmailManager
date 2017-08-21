<?php

namespace ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab;

use \ImproDev\EmailManager\Model\Status;
use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Widget\Tab\TabInterface;
use \Magento\Framework\Data\FormFactory;
use \Magento\Framework\Registry;
use \Magento\Cms\Model\Wysiwyg\Config;

/**
 * Block general tab.
 *
 * @package ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab
 */
class Reply extends Generic implements TabInterface
{

    /**
     * General constructor.
     *
     * @param Context       $context
     * @param Registry      $registry
     * @param FormFactory   $formFactory
     * @param array         $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $options,
        array $data = []
    ) {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        $form = $this->_buildForm();
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return __('Replay to Email');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle()
    {
        return __('Replay to Email');
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return \Magento\Framework\Data\Form
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _buildForm()
    {
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'reply_form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]
            ]
        );

        $model = $this->_getModel();

        $fieldset = $form->addFieldset('general', [
            'legend' => __('Reply to Email'),
        ]);

        $fieldset->addField(
            'subject',
            'text',
            [
                'name' => 'subject',
                'label' => __('Subject'),
                'id' => 'subject',
                'title' => __('Subject'),
                'required' => false,
            ]
        );


        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'reply_message',
            'editor',
            [
                'name' => 'reply_message',
                'label' => __('Message'),
                'style' => 'height:36em;',
                'required' => false,
                'config' => $wysiwygConfig
            ]
        );

        $fieldset->addField(
            'reply',
            'submit',
            [
                'name' => 'reply',
                'label' => false,
                'value' =>  __('Reply'),
                'id' => 'reply',
                'title' => __('Reply'),
                'class' => 'reply',
                'required' => false,
            ]
        );

        if ($model->getId()) {
            $form->setValues($model->getData());
        }

        return $form;
    }


    /**
     * @return BlockInterface
     */
    protected function _getModel()
    {
        return $this->_coreRegistry->registry('row_data');
    }
}
