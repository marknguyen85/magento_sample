<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tougou\Icon\Controller\Adminhtml\Index;

/**
 * Description of Delete
 *
 * @author DuyTN
 */
class Delete extends \Magento\Backend\App\Action
{
    protected $iconFactory;
    protected $helper;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Tougou\Icon\Model\IconFactory $iconFactory,
        \Tougou\Icon\Helper\Data $helper
    ) {
        $this->iconFactory = $iconFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $id = $this->getRequest()->getParam('icon_id');

        if (!($contact = $this->iconFactory->create()->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        if ($contact->getIsUndeletable() == '1') {
            $this->messageManager->addError(__('This icon is not deletable'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        if (!$this->helper->checkProduct($id)) {
            $this->messageManager->addError(__('This icon is used in Product'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        if (!$this->helper->checkProductPlan($id)) {
            $this->messageManager->addError(__('This icon is used in Product Plan'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        if ($contact->getSiteId()) {
            //TODO: ....
        }
        try {
            $contact->delete();
            $this->messageManager->addSuccess(__('Your icon has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete icon: '));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }

    protected function _isAllowed()
    {
     return $this->_authorization->isAllowed('Tougou_Icon::delete');
    }
}
