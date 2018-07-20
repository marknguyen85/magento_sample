<?php
namespace Tougou\Icon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Yesno implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => '有り',
                'value' => '1'
            ],
            1 => [
                'label' => '無し',
                'value' => '0'
            ],
        ];

        return $options;
    }
}