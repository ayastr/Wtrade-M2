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
        $sku = $interceptor->getRequest()->getParam('sku');
        $product = $this->productRepository->get($sku);
        $interceptor->getRequest()->setParams([
            'product' => $product->getId(),
            'qty' => $interceptor->getRequest()->getParam('qty')
        ]);
    }
}
