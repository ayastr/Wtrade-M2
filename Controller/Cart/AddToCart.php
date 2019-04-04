<?php

namespace Ayastr\Wtrade\Controller\Cart;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class AddToCart extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $cart;
    private $productRepository;


    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $qty = $this->getRequest()->getParam('qty');

        try {
            $product = $this->productRepository->get($sku);

            $params = array(
                'product' => $product->getId(),
                'qty' => $qty
            );
            $this->cart->addProduct($product, $params);
            $this->cart->save();
            $this->messageManager->addSuccessMessage(__('Product was successfully added.'));
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addExceptionMessage($e);
        } catch (LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e);
        }

        return $this->resultRedirectFactory->create()->setPath('*/Index/Index');
    }
}


