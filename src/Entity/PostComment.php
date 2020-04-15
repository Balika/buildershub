<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Entity\Base\Comment;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Description of PostComment
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="post_comment")
 * @ORM\Entity
 * 
 */
class PostComment extends Comment{
    
    
    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
    
    
    function __construct(Post $post = null) {        
        $this->createdAt= new DateTime();
        $this->post = $post;
        $this->status='published';
    }
    



    public function getPost() {
        return $this->post;
    }

    public function setPost(Post $post) {
        $this->post = $post;
        return $this;
    }


}
