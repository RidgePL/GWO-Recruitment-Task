<?php

declare(strict_types=1);

namespace Recruitment\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Recruitment\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     * @expectedException \Recruitment\Entity\Exception\InvalidUnitPriceException
     */
    public function itThrowsExceptionForInvalidUnitPrice(): void
    {
        $product = new Product();
        $product->setUnitPrice(0);
    }

    /**
     * @test
     * @expectedException \Recruitment\Entity\Exception\InvalidTaxValueException
     */
    public function itThrowsExceptionForInvalidTax(): void
    {
        $product = new Product();
        $product->setTax(-10);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionForInvalidMinimumQuantity(): void
    {
        $product = new Product();
        $product->setMinimumQuantity(0);
    }
}
