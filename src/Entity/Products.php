<?php
// src/Entity/User.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Brands;
use Entity\Categories;
use Entity\Stocks;
/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Products {
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $product_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $product_name;

    /**
     * @ORM\ManyToOne(targetEntity=Brands::class, inversedBy="brandProducts", cascade={"persist"})
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="brand_id")
     */
    private ?Brands $brand_id;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="categoryProducts", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private ?Categories $category_id;

    /** @var int */
    /**
     * @ORM\Column(type="integer")
     */
    private int $model_year;

    /** @var string */
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $list_price;

    /**
     * @ORM\OneToMany(targetEntity=Stocks::class, mappedBy="product_id")
     */
    private Collection $productStocks;

    /**
     * Get productStocks.
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductStocks(): Collection {
        return $this->productStocks;
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
     * Get product_name. 
     * 
     * @return product_name
     */
    public function getProductName(){
        return $this->product_name;
    }

    /**
     * Get list_price. 
     * 
     * @return list_price
     */
    public function getListPrice(){
        return $this->list_price;
    }

    /**
     * Get brand_id. 
     * 
     * @return brand_id
     */
    public function getBrandId(){
        return $this->brand_id;
    }

    /**
     * Get model_year. 
     * 
     * @return model_year
     */
    public function getModelYear(){
        return $this->model_year;
    }

    /**
     * Get category_id. 
     * 
     * @return categ_id
     */
    public function getCategoryId(){
        return $this->category_id;
    }

    /**
     * Constructor
     */
    public function __construct(){
        $this->productStocks = new ArrayCollection();
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
     * Set product_name.
     * 
     * @param string $product_name
     * 
     * @return Products
     */
    public function setProductName($product_name){
        $this->product_name = $product_name;
        return $this;
    }

    /**
     * Set brand_id.
     * 
     * @param int $brand_id
     * 
     * @return Brands
     */
    public function setBrandId($brand_id){
        $this->brand_id = $brand_id;
        return $this;
    }

     /**
     * Set category_id.
     * 
     * @param int $category_id
     * 
     * @return Category
     */
    public function setCategoryId($category_id){
        $this->category_id = $category_id;
        return $this;
    }

    /**
     * Set model_year.
     * 
     * @param int $model_year
     * 
     * @return Products
     */
    public function setModelYear($model_year){
        $this->model_year = $model_year;
        return $this;
    }

    /**
     * Set list_price.
     * 
     * @param string $list_price
     * 
     * @return Products
     */
    public function setListPrice($list_price){
        $this->list_price = $list_price;
        return $this;
    }

    public function __toString(){
        return "Products {$this->product_id} {$this->product_name} {$this->model_year} {$this->list_price}\n";
    }

}


?>