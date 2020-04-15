<?php

namespace App\Entity\Base;


use App\Entity\PostComment;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Comment
 *
 * @author Balika - MRH
 */
class Comment extends BaseModel{
   /**
     * @var string $comment
     *
     * @ORM\Column(type="string")
     */
    protected $comment;
     /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;
    
 
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    
    protected $user;
    /**
     * @var PostComment
     * @ORM\ManyToOne(targetEntity="PostComment", inversedBy="replies")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    protected $mainComment;
    
    /**
     * @ORM\OneToMany(
     *      targetEntity="PostComment",
     *      mappedBy="mainComment",       
     * )
     */
    protected $replies;
    
    function __toString(){
        return $this->comment;
    }
    public function getComment() {
        return $this->comment;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUser() {
        return $this->user;
    }

    public function getMainComment() {
        return $this->mainComment;
    }

    public function getReplies() {
        return $this->replies;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setUser(User $user=null) {
        $this->user = $user;
        return $this;
    }

    public function setMainComment(PostComment $mainComment=null) {
        $this->mainComment = $mainComment;
        return $this;
    }

    public function setReplies($replies) {
        $this->replies = $replies;
        return $this;
    }


}
