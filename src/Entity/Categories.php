<?php
// src/Entity/User.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Products;
/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Categories {
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $category_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $category_name;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="category_id")
     */
    private Collection $categoryProducts;

    /**
     * Get categoryProducts.
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryProducts(): Collection {
        return $this->brandProducts;
    }

    /**
     * Get category_id. 
     * 
     * @return category_id
     */
    public function getCategoryId(){
        return $this->category_id;
    }

    /**
     * Get category_name. 
     * 
     * @return category_name
     */
    public function getCategoryName(){
        return $this->category_name;
    }

    /**
     * Constructor
     */
    public function __construct(){
        $this->categoryProducts = new ArrayCollection();
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
     * Set category_name.
     * 
     * @param string $category_name
     * 
     * @return Category
     */
    public function setCategoryName($category_name){
        $this->category_name = $category_name;
        return $this;
    }

    public function __toString(){
        return "Category {$this->category_id} {$this->category_name}\n";
    }

}


?>