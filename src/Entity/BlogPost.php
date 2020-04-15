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
 * Description of BlogPost
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="blog_post") * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")

 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class BlogPost extends Post{
    /**
     * @var PostCategory
     * @ORM\ManyToOne(targetEntity="PostCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
   function __construct() {
       $this->postCategories = new ArrayCollection();
       $this->postTags = new ArrayCollection();
       $this->createdAt = new \DateTime();
   }
   public function getPostType() {
       return self::BLOG;
   }
   public function getCategory() {
       return $this->category;
   }

   public function setCategory(PostCategory $category=null) {
       $this->category = $category;
       return $this;
   }


}
