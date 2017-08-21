<?php

namespace ImproDev\EmailManager\Api\Data;

/**
 * Block search results interface.
 *
 * @package ImproDev\EmailManager\Api\Data
 */
interface GridSearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return \ImproDev\EmailManager\Api\Data\GridInterface[]
     */
    public function getItems();

    /**
     * Set blocks list.
     *
     * @param \ImproDev\EmailManager\Api\Data\GridInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}