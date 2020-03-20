<?php
declare(strict_types=1);

namespace Recruitment\Cart;


use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class Cart
{
    /** @var array|Item[] */
    private $items;

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function addProduct(Product $product, int $quantity = 1): self
    {
        $index = $this->contains($product);
        if($index === -1) {
            $this->items[] = new Item($product, $quantity);
        }else{
            $this->updateProduct($index, $quantity);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        $index = $this->contains($product);
        if($index !== -1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $item){
            $totalPrice += $item->getTotalPrice();
        }

        return $totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalGrossPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $item){
            $totalPrice += $item->getTotalGrossPrice();
        }

        return $totalPrice;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(Product $product, int $quantity): self
    {
        $index = $this->contains($product);
        if($index === -1){
            $this->addProduct($product, $quantity);
        }else{
            $this->items[$index]->setQuantity($quantity);
        }

        return $this;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function checkout(int $orderId): Order
    {
        $order = new Order($orderId, $this->serializeItems());
        $this->clear();

        return $order;
    }

    /**
     * @return array
     */
    private function serializeItems(): array
    {
        $serialized = [];
        foreach ($this->items as $item){
            $serialized[] = $item->serialize();
        }
        return $serialized;
    }

    /**
     *
     */
    private function clear(): void
    {
        $this->items = [];
    }

    /**
     * @param int $index
     * @param int $quantity
     */
    private function updateProduct(int $index, int $quantity): void
    {
        $oldQuantity = $this->items[$index]->getQuantity();
        $this->items[$index]->setQuantity($oldQuantity + $quantity);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        if(!isset($this->items[$index])){
            throw new \OutOfBoundsException();
        }
        return $this->items[$index];
    }

    /**
     * @param Product $product
     * @return int
     */
    private function contains(Product $product): int
    {
        if(isset($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->getProduct() === $product) {
                    return $key;
                }
            }
        }

        return -1;
    }
}