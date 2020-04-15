<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of StatusPost
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="status_post")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * 
 */
class StatusPost extends Post {

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     * 
     */
    protected $target;
    
     /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="posts")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    function __construct() {
        $this->postCategories = new ArrayCollection();
        $this->postTags = new ArrayCollection();
        $this->isCommentable = TRUE;
        $this->isPublished = TRUE;
        $this->commentCount = 0;
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget(User $target = null) {
        $this->target = $target;
        return $this;
    }

    public function getPostType() {
        return self::STATUS;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany(Company $company=null) {
        $this->company = $company;
        return $this;
    }


}
