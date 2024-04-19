<?php
// src/Entity/User.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Products;
use Entity\Stores;
/**
 * @ORM\Entity
 * @ORM\Table(name="stocks")
 */
class Stocks {
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $stock_id;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="storeStocks", cascade={"persist"})
     * @ORM\JoinColumn(name="store_id", referencedColumnName="store_id")
     */
    private ?Stores $store_id;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="productStocks", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     */
    private ?Products $product_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer", nullable="true")
     */
    private int $quantity;

    /**
     * Get stock_id. 
     * 
     * @return stock_id
     */
    public function getStockId(){
        return $this->stock_id;
    }

    /**
     * Get store_id. 
     * 
     * @return store_id
     */
    public function getStoreId(){
        return $this->store_id;
    }

    /**
     * Get product_id. 
     * 
     * @return product_id
     */
    public function getProductId(){
        return $this->product_id;
    }

    /**
     * Get quantity. 
     * 
     * @return quantity
     */
    public function getQuantity(){
        return $this->quantity;
    }

    /**
     * Set stock_id.
     * 
     * @param int $stock_id
     * 
     * @return Stocks
     */
    public function setStockId($stock_id){
        $this->stock_id = $stock_id;
        return $this;
    }

    /**
     * Set store_id.
     * 
     * @param string $store_id
     * 
     * @return Stores
     */
    public function setStoreId($store_id){
        $this->store_id = $store_id;
        return $this;
    }

    /**
     * Set product_id.
     * 
     * @param int $product_id
     * 
     * @return Products
     */
    public function setProductId($product_id){
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * Set quantity.
     * 
     * @param int $quantity
     * 
     * @return Stocks
     */
    public function setQuantity($quantity){
        $this->quantity = $quantity;
        return $this;
    }

    public function __toString(){
        return "Stocks {$this->stock_id} {$this->store_id} {$this->product_id} {$this->quantity}\n";
    }

}


?>