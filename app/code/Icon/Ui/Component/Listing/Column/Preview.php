<?php
namespace Cowell\Icon\Ui\Component\Listing\Column;

class Preview extends \Magento\Ui\Component\Listing\Columns\Column
{

    /**
     * Preview constructor.
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $preDefinedColors = [
            '1' => "#000000",
            '2' => '#FFFFFF',
            '3' => '#E60012',
            '4' => '#F39800',
            '5' => '#FFF100',
            '6' => '#6A0B07',
            '7' => '#AA2A83',
            '8' => '#EB0091',
            '9' => '#FA91D0',
            '10' => '#8FC31F',
            '11' => '#009944',
            '12' => '#13A9A0',
            '13' => '#00A0E9',
            '14' => '#1D2088'
        ];
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $itemColor = $preDefinedColors[$item['font_color']];
                $itemBg = $preDefinedColors[$item['bg_color']];
                $itemName = $item['name'];
                if ($item['bg_color'] == '2') {
                    $borderStyle = ' border: 1px solid ' . $itemColor . ';';
                }else {
                    $borderStyle = '';
                }
                $item['preview'] = "<span style='color:".$itemColor."; background-color: ".$itemBg."; padding: 0 5px; border-radius: 5px;".$borderStyle."'>$itemName</span>";
            }
        }
        return $dataSource;
    }
}