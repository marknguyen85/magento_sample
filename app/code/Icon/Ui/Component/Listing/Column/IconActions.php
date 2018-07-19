<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tougou\Icon\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Description of Columns
 *
 * @author DuyTN
 */
class IconActions extends Column {

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(
        array $dataSource
    ) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['icon_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl('icon/index/edit', ['icon_id' => $item['icon_id']]),
                        'label' => __('Edit')
                    ];
                    if ($item['is_undeletable'] == 0) {
                        $item[$name]['delete'] = [
                            'href' => $this->urlBuilder->getUrl(
                                'icon/index/delete',
                                ['icon_id' => $item['icon_id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Attention'),
                                'message' => __('Are you sure you want to delete ${ $.$data.name } icon?')
                            ]
                        ];
                    }
                }
            }

            return $dataSource;
        }
    }
}
