<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseModel as Model;

/**
 * Description of EquipmentAssignment
 *
 * @author Balika
 */

/**
 * @ORM\Table(name="equipment_assignment")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * 
 */
class EquipmentAssignment extends Model {

    /**
     * @var string $assignmentType
     *
     * @ORM\Column(type="string")
     */
    protected $assignmentType;

    /**
     * @var string $garageName
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $garageName;

    /**
     * @var string $garageName
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $garageContact;

    /**
     * @var string $description
     *
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var datetime $startDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var datetime $endDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $endDate;
    // Entity Relationship
    //Relations with other entites
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Equipment
     * @ORM\ManyToOne(targetEntity="Equipment", inversedBy="associations")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    protected $equipment;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="associations")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    
    public function getAssignmentType() {
        return $this->assignmentType;
    }

    public function getGarageName() {
        return $this->garageName;
    }

    public function getGarageContact() {
        return $this->garageContact;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getEquipment(): Equipment {
        return $this->equipment;
    }

    public function getCompany(): Company {
        return $this->company;
    }

    public function setAssignmentType($assignmentType) {
        $this->assignmentType = $assignmentType;
        return $this;
    }

    public function setGarageName($garageName) {
        $this->garageName = $garageName;
        return $this;
    }

    public function setGarageContact($garageContact) {
        $this->garageContact = $garageContact;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setStartDate( $startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate( $endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setEquipment(Equipment $equipment) {
        $this->equipment = $equipment;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }



}
