<?php

/**
 * ImproDev_EmailManager Grid Collection.
 *
 * @author  ImproDev
 */
namespace ImproDev\EmailManager\Model\ResourceModel\Grid;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('ImproDev\EmailManager\Model\Grid', 'ImproDev\EmailManager\Model\ResourceModel\Grid');
    }
}