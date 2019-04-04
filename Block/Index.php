<?php

namespace Ayastr\Wtrade\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;
    private $productRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->productRepository = $productRepository;
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('SKU');
        $collection->setPageSize(10);
        return $collection;
    }

    public function loadMyProduct($sku)
    {
        return $this->productRepository->get($sku);
    }
}

