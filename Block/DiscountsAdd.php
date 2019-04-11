<?php

namespace Ayastr\Wtrade\Block;

class DiscountsAdd extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('amount_for_discounts', ['label' => __('Amount for discounts, $')]);
        $this->addColumn('discounts_amount', ['label' => __('Discounts amount, %')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add discount');
    }
}