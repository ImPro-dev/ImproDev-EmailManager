<?php

namespace ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab;

use \ImproDev\EmailManager\Model\Status;
use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Widget\Tab\TabInterface;
use \Magento\Framework\Data\FormFactory;
use \Magento\Framework\Registry;

/**
 * Block general tab.
 *
 * @package ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab
 */
class General extends Generic implements TabInterface
{

    /**
     * General constructor.
     *
     * @param Context       $context
     * @param Registry      $registry
     * @param FormFactory   $formFactory
     * @param Status        $options
     * @param array         $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Status $options,
        array $data = []
    ) {
        $this->_options = $options;
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
        return __('General Settings');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle()
    {
        return __('General Settings');
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
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getData('action'),
                'method' => 'post'
                ]
            ]
        );

        $fieldset = $form->addFieldset('general', [
            'legend' => __('General Settings'),
        ]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', [
                'name' => 'block[id]',
            ]);
        }

        $fieldset->addField(
            'name',
            'label',
            [
                'name' => 'name',
                'label' => __('Name'),
                'id' => 'name',
                'title' => __('Name'),
                'required' => false,
            ]
        );
        $fieldset->addField(
            'email',
            'label',
            [
                'name' => 'email',
                'label' => __('Email'),
                'id' => 'email',
                'title' => __('Email'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            'phone',
            'label',
            [
                'name' => 'phone',
                'label' => __('Phone'),
                'id' => 'phone',
                'title' => __('Phone'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            'message',
            'label',
            [
                'name' => 'message',
                'label' => __('Message'),
                'style' => 'height:36em;',
                'required' => false,
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
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
