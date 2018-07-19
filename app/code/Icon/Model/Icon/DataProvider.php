<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Icon\Model\Icon;

use Icon\Model\ResourceModel\Icon\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Description of DataProvider
 *
 * @author DuyTN
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $storeManager;
    protected $dataPersistor;
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $iconCollectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->collection = $iconCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $icon) {
            $data = $icon->getData();
            $this->loadedData[$icon->getIconId()] = $data;
        }
        $data = $this->dataPersistor->get('icon_icon');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getData('icon_id')] = $model->getData();
            $this->dataPersistor->clear('icon_icon');
        }
        if($this->request->getParam('icon_id')) {
            $this->loadedData[$this->request->getParam('icon_id')]['check_exist'] = true;
        } else {
            $this->loadedData[$this->request->getParam('icon_id')]['check_exist'] = false;
        }
        return $this->loadedData;

    }
}

