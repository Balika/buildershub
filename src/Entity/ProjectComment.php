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
 * Description of ProjectComment
 *
 * @author Edmond
 */
/**
 * @ORM\Table(name="project_comment")
 * @ORM\Entity
 * 
 */
class ProjectComment extends Comment{
    
    
    /**
     * @var Work
     * @ORM\ManyToOne(targetEntity="Work", inversedBy="comments")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;
    
   
    function __construct(Work $project = null) {        
        $this->createdAt= new DateTime();
        $this->project = $project;
        $this->status='published';
    }
    public function getProject() {
        return $this->project;
    }

    public function setProject(Work $project) {
        $this->project = $project;
        return $this;
    }
}
