<?php

namespace App\HubernizeModel\Diary;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

/**
 * Description of CreateDiaryEntry
 *
 * @author Balika
 */
class CreateDiaryEntry {

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="10", max="100")
     * @var string
     */
    public $projectName;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $entryName;

    /**
     * @Assert\DateTime()
     * @var DateTimeImmutable
     */
    public $createdAt;

    
    /**
     * 
     * @var string
     */
    public $location;
    /**
     * 
     * @var string
     */
    public $latLong;
    /**
     * 
     * @var string
     */
    public $activity;
    /**
     * 
     * @var string
     */
    public $shiftName;
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
    public $safeGuards;
    /**
     * 
     * @var string
     */
    public $rainfall;
    /**
     * 
     * @var string
     */
    public $weather;
    /**
     * 
     * @var string
     */
    public $siteConditions;
    /**
     * 
     * @var File
     */
    public $photo;
    /**
     * 
     * @var File
     */
    public $video;
    /**
     * 
     * @var File
     */
    public $gallery;

}
