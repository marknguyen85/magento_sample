<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cowell\Icon\Model;
/**
 * Description of Brand
 *
 * @author DuyTN
 */
class Icon extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Cowell\Icon\Model\ResourceModel\Icon');
    }
}
