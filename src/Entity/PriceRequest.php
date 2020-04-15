<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\BaseModel as Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of PriceRequest
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="price_request")
 * @ORM\Entity(repositoryClass="App\Repository\PriceRequestRepository")
 * 
 */
class PriceRequest extends Model {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;
     
    /**
     * @var array $products
     *
     * @ORM\Column(type="array")
     */
    protected $products;
    
    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;
    
    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $requestNo;
    
    /**
     * @var datetime $replyDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $replyDate;
    
    
     /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
   
    
    function __construct() {      
        $this->createdAt= new \Datetime();
        $this->products = array();
    }
    


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

 

    public function setProducts($products) {
        $this->products = $products;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts() {
        if ($this->products == null)
            $this->products = array();
        return array_unique($this->products);
    }

    

    /**
     * Set status
     *
     * @param string $status
     *
     * @return PriceRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set requestNo
     *
     * @param string $requestNo
     *
     * @return PriceRequest
     */
    public function setRequestNo($requestNo)
    {
        $this->requestNo = $requestNo;

        return $this;
    }

    /**
     * Get requestNo
     *
     * @return string
     */
    public function getRequestNo()
    {
        return $this->requestNo;
    }

    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     *
     * @return PriceRequest
     */
    public function setReplyDate($replyDate)
    {
        $this->replyDate = $replyDate;

        return $this;
    }

    /**
     * Get replyDate
     *
     * @return \DateTime
     */
    public function getReplyDate()
    {
        return $this->replyDate;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return PriceRequest
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
