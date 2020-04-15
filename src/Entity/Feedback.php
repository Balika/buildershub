<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Feedback
 *
 * @author Edmond
 */

/**
 * @ORM\Table(name="feedback")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FeedbackRepository")
 */
class Feedback{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    protected $email;

    /**
     * @var string $message
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $message;

    /**
     * @var string $createdAt
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

   

    function __construct($email, $message) {
        $this->email=$email;
        $this->message = $message;
    }

    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }
}
