<?php

namespace Ayastr\Wtrade\Plugin;

class SetProductParams
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $interceptor)
    {
        $addedFromWtrade = $interceptor->getRequest()->getParam('added-from-wtrade');
        if ($addedFromWtrade) {
            try {
                $requestParams = $interceptor->getRequest()->getParams();
                $product = $this->productRepository->get($requestParams['sku']);
                $interceptor->getRequest()->setParams([
                    'product' => $product->getId(),
                    'qty' => $requestParams['qty'],
                ]);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
    }
}
