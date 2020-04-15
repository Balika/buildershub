<?php

// src/AppBundle/Entity/Base/BaseModel.php

namespace App\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**

 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 * @ORM\HasLifecycleCallbacks
 */
class BaseModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    protected $updatedAt;

    /**
     * Set createdAt
     * 
     * @param \DateTime $createdAt
     * 
     */
    public function setCreatedAt($createdAt = null) {
        $this->createdAt = $createdAt;        
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * 
     */
    public function setUpdatedAt($updatedAt=null) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function PrePersist() {
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * @ORM\PreUpdate()
     */
    public function PreUpdate() {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function getId() {
        return $this->id;
    }

    public function generateRandomString($length = 8) {
        $characters = "abcdefghijklmnopqrstuvwxyz0123456789";
        $randomPassword = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[mt_rand(0, $max)];
        }
        return $randomPassword;
    }

}
