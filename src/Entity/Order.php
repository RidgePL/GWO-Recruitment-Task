<?php
declare(strict_types=1);

namespace Recruitment\Entity;


use Recruitment\Cart\Item;

class Order
{
    private const FIELD_ID                = 'id';
    private const FIELD_ITEMS             = 'items';
    private const FIELD_TOTAL_PRICE       = 'total_price';
    private const FIELD_TOTAL_GROSS_PRICE = 'total_gross_price';

    /** @var array|Item[] */
    private $items;

    /** @var int  */
    private $id;

    /** @var int */
    private $totalPrice;

    /** @var int */
    private $totalGrossPrice;

    public function __construct(int $orderId, array $items)
    {
        $this->id = $orderId;
        $this->items = $items;
        $this->totalPrice = $this->calculateOrderPrice();
        $this->totalGrossPrice = $this->calculateGrossOrderPrice();
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        return [
            self::FIELD_ID          => $this->id,
            self::FIELD_ITEMS       => $this->items,
            self::FIELD_TOTAL_PRICE => $this->totalPrice,
            self::FIELD_TOTAL_GROSS_PRICE => $this->totalGrossPrice,
        ];
    }

    /**
     * @return int
     * @throws Exception\InvalidUnitPriceException
     */
    private function calculateOrderPrice(): int
    {
        $totalPrice = 0;
        foreach($this->items as $item) {
            $item = Item::deserialize($item);
            $totalPrice += $item->getTotalPrice();
        }

        return $totalPrice;
    }

    /**
     * @return int
     * @throws Exception\InvalidUnitPriceException
     */
    private function calculateGrossOrderPrice(): int
    {
        $totalPrice = 0;
        foreach($this->items as $item) {
            $item = Item::deserialize($item);
            $totalPrice += $item->getTotalGrossPrice();
        }

        return $totalPrice;
    }
}