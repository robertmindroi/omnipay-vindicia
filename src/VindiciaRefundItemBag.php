<?php

namespace Omnipay\Vindicia;

use Omnipay\Common\ItemBag;

/**
 * Class VindiciaRefundItemBag
 *
 * @package Omnipay\Vindicia
 */
class VindiciaRefundItemBag extends ItemBag
{
    /**
     * @var array<int, mixed>
     */
    protected $items;

    /**
     * Add an item to the bag
     *
     * @param  VindiciaRefundItem|array $item An existing item, or associative array of item parameters
     * @return void
     */
    public function add($item)
    {
        if ($item instanceof VindiciaRefundItem) {
            $this->items[] = $item;
        } else {
            $this->items[] = new VindiciaRefundItem($item);
        }
    }
}
