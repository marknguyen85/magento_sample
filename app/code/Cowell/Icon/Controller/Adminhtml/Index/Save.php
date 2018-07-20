<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tougou\Icon\Controller\Adminhtml\Index;

/**
 * Description of Save
 *
 * @author DuyTN
 */
class Save extends \Magento\Backend\App\Action{
    protected $dataPersistor;
    protected $authSession;
    protected $date;
    protected $iconFactory;
    protected $helper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\Auth\Session\Proxy $authSession,
        \Tougou\Icon\Model\IconFactory $iconFactory,
        \Tougou\Icon\Helper\Data $helper
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->date = $date;
        $this->authSession = $authSession;
        $this->iconFactory = $iconFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }
    
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $max = $this->helper->getMaxCode();
            $id = $this->getRequest()->getParam('icon_id');
            $model = $this->iconFactory->create()->load($id);
            //Check if already exist new icon
            if (!$id) {
                if (!$max || $max < 1000) {
                    $data['code'] = 1000;
                } else {
                    $data['code'] = $max + 1;
                }
            }
            if (!$model->getIconId() && $id) {
                $this->messageManager->addErrorMessage(__('This Icon no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data['upuser_id'] = $this->authSession->getUser()->getId();

            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Icon.'));
                $this->dataPersistor->clear('Tougou_icon_icon');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['icon_id' => $model->getIconId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Icon.'));
            }
        
            $this->dataPersistor->set('Tougou_icon_icon', $data);
            return $resultRedirect->setPath('*/*/edit', ['icon_id' => $this->getRequest()->getParam('icon_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    
    protected function _isAllowed()
    {
     return $this->_authorization->isAllowed('Tougou_Icon::icons');
    }
}
