<?php
namespace Cowell\Icon\Model\ResourceModel\Icon;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->_init('Cowell\Icon\Model\Icon', 'Cowell\Icon\Model\ResourceModel\Icon');
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->storeManager = $storeManager;
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->join(
            'store_group as store',
            'main_table.site_id = store.group_id',
            ['site_name' => 'group_id']
        );
        $this->addFilterToMap('site_name','group_id');
        $this->addFilterToMap('name','main_table.name');
        $this->addFilterToMap('code','main_table.code');
    }
}
