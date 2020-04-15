<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\HubernizeModel\Diary;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

/**
 * Description of CreateDiaryEntryExtra
 *
 * @author Balika
 */
class CreateDiaryEntryExtra {
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="100")
     * @var string
     */
    public $contractorName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $description;

    /**
     * @Assert\DateTime()
     * @var DateTimeImmutable
     */
    public $createdAt;

    /**
     * 
     * @var string
     */
    public $shiftStart;
    /**
     * 
     * @var string
     */
    public $shiftEnd;
    /**
     * 
     * @var string
     */
    public $costCode;
    /**
     * 
     * @var decimal
     */
    public $quantity;
    /**
     * 
     * @var string
     */
    public $comments;
   
}
