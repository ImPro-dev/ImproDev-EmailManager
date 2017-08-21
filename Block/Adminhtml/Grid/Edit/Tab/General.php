<?php

namespace ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab;

use ImproDev\EmailManager\Api\Data\GridInterface;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

/**
 * Block general tab.
 *
 * @package ImproDev\EmailManager\Block\Adminhtml\Grid\Edit\Tab
 */
class General extends Generic implements TabInterface
{
    /**
     * @var Store
     */
    protected $_systemStore;

    /**
     * @var Enabledisable
     */
    protected $_enabledisable;

    /**
     * General constructor.
     *
     * @param Store         $systemStore
     * @param Enabledisable $enabledisable
     * @param Context       $context
     * @param Registry      $registry
     * @param FormFactory   $formFactory
     * @param array         $data
     */
    public function __construct(
        Store $systemStore,
        Enabledisable $enabledisable,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \ImproDev\EmailManager\Model\Status $options,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_enabledisable = $enabledisable;
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

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'message',
            'label',
            [
                'name' => 'message',
                'label' => __('Message'),
                'style' => 'height:36em;',
                'required' => false,
//                'config' => $wysiwygConfig
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
                'required' => true,
            ]
        );


        if ($model->getId()) {
            $form->setValues($model->getData());
        }
//        else {
//            $form->setValues([
//                'status' => BlockInterface::STATUS_ENABLED,
//                'store_id' => [0]
//            ]);
//        }

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
