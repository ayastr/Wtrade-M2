<?php

namespace  Ayastr\Wtrade\Controller\Product;

class Autocomplete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var  Ayastr\Wtrade\Model\ProductStore
     */
    protected $productStore;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Ayastr\Wtrade\Model\ProductStore $productStore
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productStore = $productStore;

        return parent::__construct($context);
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $products = $this->productStore->findBySKU($params['sku']);
        $result = $this->resultJsonFactory->create();

        return $result->setData($products);
    }
}