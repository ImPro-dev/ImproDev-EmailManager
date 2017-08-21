<?php

namespace ImproDev\EmailManager\Api;

use ImproDev\EmailManager\Api\Data\GridInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface BlockRepositoryInterface
 *
 * @package TemplateMonster\Parallax\Api
 */
interface BlockRepositoryInterface
{
    /**
     * Save block entity.
     *
     * @param GridInterface $block
     *
     * @return mixed
     */
    public function save(GridInterface $block);

    /**
     * Get block entity by id.
     *
     * @param int $id
     *
     * @return GridInterface
     */
    public function getById($id);

    /**
     * Delete block item entity.
     *
     * @param GridInterface $block
     *
     * @return mixed
     */
    public function delete(GridInterface $block);

    /**
     * Delete block entity by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function deleteById($id);

    /**
     * Get list of blocks by search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \ImproDev\EmailManager\Api\Data\GridSearchResultsInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Create block model instance.
     *
     * @return GridInterface
     */
    public function getModelInstance();
}
