<?php
// src/Entity/User.php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Stores;
/**
 * @ORM\Entity
 * @ORM\Table(name="employees")
 */
class Employees {
    /** @var int */
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $employee_id;

    /**
     * @ORM\ManyToOne(targetEntity=Stores::class, inversedBy="storeEmployees", cascade={"persist"})
     * @ORM\JoinColumn(name="store_id", referencedColumnName="store_id")
     */
    private ?Stores $store_id;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_name;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_email;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_password;

    /** @var string */
    /**
     * @ORM\Column(type="string")
     */
    private string $employee_role;

    /**
     * Get employee_id. 
     * 
     * @return employee_id
     */
    public function getEmployeeId(){
        return $this->employee_id;
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
     * Get employee_name. 
     * 
     * @return employee_name
     */
    public function getEmployeeName(){
        return $this->employee_name;
    }

    /**
     * Get employee_email. 
     * 
     * @return employee_email
     */
    public function getEmployeeEmail(){
        return $this->employee_email;
    }

    /**
     * Get employee_password. 
     * 
     * @return employee_password
     */
    public function getEmployeePassword(){
        return $this->employee_password;
    }

    /**
     * Get employee_role. 
     * 
     * @return employee_role
     */
    public function getEmployeeRole(){
        return $this->employee_role;
    }

    /**
     * Set employee_id.
     * 
     * @param int $employee_id
     * 
     * @return Employees
     */
    public function setEmployeeId($employee_id){
        $this->employee_id = $employee_id;
        return $this;
    }

    /**
     * Set store_id.
     * 
     * @param int $store_id
     * 
     * @return Stores
     */
    public function setStoreId($store_id){
        $this->store_id = $store_id;
        return $this;
    }

    /**
     * Set employee_name.
     * 
     * @param string $employee_name
     * 
     * @return Employees
     */
    public function setEmployeeName($employee_name){
        $this->employee_name = $employee_name;
        return $this;
    }

    /**
     * Set employee_email.
     * 
     * @param string $employee_email
     * 
     * @return Employees
     */
    public function setEmployeeEmail($employee_email){
        $this->employee_email = $employee_email;
        return $this;
    }

    /**
     * Set employee_password.
     * 
     * @param string $employee_password
     * 
     * @return Employees
     */
    public function setEmployeePassword($employee_password){
        $this->employee_password = $employee_password;
        return $this;
    }

    /**
     * Set employee_role.
     * 
     * @param string $employee_role
     * 
     * @return Employees
     */
    public function setEmployeeRole($employee_role){
        $this->employee_role = $employee_role;
        return $this;
    }

    public function __toString(){
        return "Stocks {$this->employee_name} {$this->employee_email} {$this->employee_email} {$this->employee_password} {$this->employee_role}\n";
    }

}


?>