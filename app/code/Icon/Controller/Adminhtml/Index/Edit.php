<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Icon\Controller\Adminhtml\Index;

/**
 * Description of Edit
 *
 * @author DuyTN
 */
class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $coreRegistry;
   
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry= $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('icon_id');
        $model = $this->_objectManager->create('Icon\Model\Icon');
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Icon no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        
        // 5. Build edit form
        $resultPage = $this->resultPageFactory->create();
        
        $resultPage->addBreadcrumb(
            $id ? __('Edit Icon') : __('New Icon'),
            $id ? __('Edit Icon') : __('New Icon')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Icon'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Icon'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
     return $this->_authorization->isAllowed('Icon::edit');
    }
}
