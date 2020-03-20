<?php
declare(strict_types=1);

namespace Recruitment\Cart;


use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    private const FIELD_PRODUCT_ID        = 'id';
    private const FIELD_QUANTITY          = 'quantity';
    private const FIELD_TOTAL_PRICE       = 'total_price';
    private const FIELD_TOTAL_GROSS_PRICE = 'total_gross_price';

    /** @var Product */
    private $product;

    /** @var int  */
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->setProduct($product);
        $this->setQuantity($quantity);
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->product->getUnitPrice() * $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalGrossPrice(): int
    {
        return $this->product->getGrossPrice() * $this->quantity;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            self::FIELD_PRODUCT_ID        => $this->getProduct()->getId(),
            self::FIELD_QUANTITY          => $this->getQuantity(),
            self::FIELD_TOTAL_PRICE       => $this->getTotalPrice(),
            self::FIELD_TOTAL_GROSS_PRICE => $this->getTotalGrossPrice(),
        ];
    }

    /**
     * @param array $data
     * @return Item
     * @throws \Recruitment\Entity\Exception\InvalidUnitPriceException
     */
    public static function deserialize(array $data)
    {
        $product = (new Product())->setId($data[self::FIELD_PRODUCT_ID])
            ->setUnitPrice(self::calculateUnitPrice($data))
            ->setTax(self::calculateTax($data));
        return new self($product, (int)$data[self::FIELD_QUANTITY]);
    }

    /**
     * @param array $data
     * @return int
     */
    private static function calculateUnitPrice(array $data): int
    {
        return $data[self::FIELD_TOTAL_PRICE] / $data[self::FIELD_QUANTITY];
    }

    /**
     * @param array $data
     * @return int
     */
    private static function calculateTax(array $data): int
    {
        $unitGrossPrice = $data[self::FIELD_TOTAL_GROSS_PRICE] / $data[self::FIELD_QUANTITY];
        return (int)(($unitGrossPrice - self::calculateUnitPrice($data)) / self::calculateUnitPrice($data) * 100);
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): void
    {
        if($quantity >= $this->getProduct()->getMinimumQuantity()) {
            $this->quantity = $quantity;
        }else{
            throw new QuantityTooLowException();
        }
    }


}