<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cowell\Icon\Model\ResourceModel;
/**
 * Description of Brand
 *
 * @author DuyTN
 */
class Icon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    
    protected function _construct()
    {
        $this->_init('icon', 'icon_id');
    }

}
