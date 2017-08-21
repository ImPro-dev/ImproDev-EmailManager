<?php
/**
 * ImproDev_EmailManager Contact Index Controller Plugin.
 * @package     ImproDev_EmailManager
 * @author      ImproDev
 *
 */

namespace ImproDev\EmailManager\Plugin\Controller\Index;

use \Magento\Contact\Controller\Index\Post;

class PostPlugin
{
    /**
     * Save form data to db
     *
     * @param string|null $scope
     * @return null
     */
    public function afterExecute(Post $subject, $result, $scope = null)
    {
        $data = $subject->getRequest()->getPostValue();
        if (!$data) {
            return $result;
        }
        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $rowData = $objectManager->create('ImproDev\EmailManager\Model\Grid');

            $data['phone'] = $data['telephone'];
            $data['message'] = $data['comment'];
            unset($data['telephone'], $data['comment']);

            $rowData->setData($data);
            $rowData->save();
        } catch (Exception $e) {
            return $result;
        }

        return $result;
    }

}
