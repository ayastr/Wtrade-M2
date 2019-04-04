<?php

namespace Ayastr\Wtrade\Model;

use Magento\Catalog\Model\Product\Type;

class ProductStore extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     */
    protected $collectionFactory;
    protected $stockHelper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\CatalogInventory\Helper\Stock $stockHelper,
        array $data = []
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->stockHelper = $stockHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @param string $query
     * @return array
     */
    public function findBySKU(string $query)
    {
        $productCollection = $this->collectionFactory->create();
        $result = [];
        $productCollection
            ->addAttributeToSelect(['sku', 'name', 'type_id', 'qty'])
            ->addFieldToFilter('sku', ['like' => '%' . $query . '%'])
            ->addFieldToFilter('type_id', ['eq' => Type::TYPE_SIMPLE])
            ->setPageSize(10)
            ->setCurPage(1);
        $this->stockHelper->addInStockFilterToCollection($productCollection);
        $productCollection->load();
        foreach ($productCollection as $product) {
            $result[$product->getSKU()] = $product->getName();
        }
        return $result;
    }
}