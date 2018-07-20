<?php
namespace Tougou\Icon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Color implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => __('黒'),
                'value' => 1
            ],
            1 => [
            'label' => __('白'),
                'value' => 2
            ],
            2 => [
                'label' => __('赤'),
                'value' => 3
            ],
            3 => [
                'label' => __('オレンジ'),
                'value' => 4
            ],
            4 => [
                'label' => __('黄色'),
                'value' => 5
            ],
            5 => [
                'label' => __('深赤'),
                'value' => 6
            ],
            6 => [
                'label' => __('マゼンタ'),
                'value' => 7
            ],
            7 => [
                'label' => __('濃ピンク'),
                'value' => 8
            ],
            8 => [
                'label' => __('薄ピンク'),
                'value' => 9
            ],
            9 => [
                'label' => __('黄緑'),
                'value' => 10
            ],
            10 => [
                'label' => __('緑'),
                'value' => 11
            ],
            11 => [
                'label' => __('青緑'),
                'value' => 12
            ],
            12 => [
                'label' => __('水色'),
                'value' => 13
            ],
            13 => [
                'label' => __('青'),
                'value' => 14
            ]
        ];

        return $options;
    }
}