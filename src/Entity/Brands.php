<?php
// src/Entity/User.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Products;
/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 */
class Brands {
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $brand_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $brand_name;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="brand_id")
     */
    private Collection $brandProducts;

    /**
     * Get brandProduct.
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrandProduct(): Collection {
        return $this->brandProducts;
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
     * Get brand_name. 
     * 
     * @return brand_name
     */
    public function getBrandName(){
        return $this->brand_name;
    }

    /**
     * Constructor
     */
    public function __construct(){
        $this->brandProducts = new ArrayCollection();
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
     * Set brand_name.
     * 
     * @param string $brand_name
     * 
     * @return Brands
     */
    public function setBrandName($brand_name){
        $this->brand_name = $brand_name;
        return $this;
    }

    public function __toString(){
        return "Brand {$this->brand_id} {$this->brand_name}\n";
    }

}


?>