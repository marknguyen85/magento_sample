<?php

namespace Icon\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 * @package Icon\Helper
 */
class Data extends AbstractHelper
{

    protected $_iconFactory;
    protected $_productCollectionFactory;
    protected $_productPlanCollectionFactory;
    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
        \Icon\Model\IconFactory $iconFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \ProductPlan\Model\ResourceModel\ProductPlan\CollectionFactory $productPlanCollectionFactory
    )
    {
        $this->_iconFactory = $iconFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productPlanCollectionFactory = $productPlanCollectionFactory;
        parent::__construct($context);
    }

    public function getMaxCode() {
        $collection = $this->_iconFactory->create()->getCollection();
        $collection->setOrder('0 + main_table.code','DESC');
        $item = $collection->getFirstItem();
        return $item->getCode();
    }

    /**
     * Check if icon is used in product
     * @param id $id
     */
    public function checkProduct($id) {
        $collection = $this->_productCollectionFactory->create();

        $collection->addAttributeToFilter(
            array(
                array('attribute'=> 'icon1','eq' => $id),
                array('attribute'=> 'icon2','eq' => $id),
                array('attribute'=> 'icon3','eq' => $id),
                array('attribute'=> 'icon4','eq' => $id),
                array('attribute'=> 'icon5','eq' => $id),
                array('attribute'=> 'icon6','eq' => $id),
                array('attribute'=> 'icon7','eq' => $id),
                array('attribute'=> 'icon8','eq' => $id),
                array('attribute'=> 'icon9','eq' => $id),
                array('attribute'=> 'icon10','eq' => $id)
            ), null, 'left'
        );
        return $collection->getSize() < 1 ? true : false;
    }

    /**
     * Check if icon is used in product planning
     * @param id $id
     */
    public function checkProductPlan($id) {
        $collection = $this->_productPlanCollectionFactory->create();
        $collection->addFieldToFilter('icon_id', array('eq' => $id));
        return $collection->getSize() < 1 ? true : false;
    }
}
