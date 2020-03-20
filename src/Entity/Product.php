<?php
declare(strict_types = 1);

namespace Recruitment\Entity;


use Recruitment\Entity\Exception\InvalidTaxValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{

    private const ALLOWED_TAX_VALUES = [ 0, 5, 8, 23];

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $unitPrice;

    /** @var int */
    private $minimumQuantity = 1;

    /** @var int */
    private $tax;

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     * @return Product
     */
    public function setTax(int $tax): self
    {
        if(!in_array($tax, self::ALLOWED_TAX_VALUES)){
            throw new InvalidTaxValueException();
        }
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): self
    {
        if($unitPrice > 0) {
            $this->unitPrice = $unitPrice;
        }else{
            throw new InvalidUnitPriceException();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if($minimumQuantity > 0) {
            $this->minimumQuantity = $minimumQuantity;
        } else {
            throw new \InvalidArgumentException();
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getGrossPrice(): int
    {
        return (int) ($this->getUnitPrice() + ($this->getTax() / 100) * $this->getUnitPrice());
    }

}