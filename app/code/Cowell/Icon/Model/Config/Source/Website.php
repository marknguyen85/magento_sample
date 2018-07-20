<?php
namespace Tougou\Icon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\GroupFactory;

class Website extends \Magento\Framework\DataObject implements ArrayInterface
{
    /**
     * @return array
     */
    protected $_groupFactory;
    
    public function __construct(
        GroupFactory $groupFactory
    ) {
        $this->_groupFactory = $groupFactory;
    }
    
    public function toOptionArray()
    {
        $collection = $this->_groupFactory->create()->getCollection()->selectSiteExt();
        $options = array();
        $groups = $collection->getData();
        $options[] = ['label' => __(' '), 'value' => ''];
        foreach ($groups as $group) {
            $options[] = ['label' => $group["name"], 'value' => $group["group_id"]];
        }
        return $options;
    }
}