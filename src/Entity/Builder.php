<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Builder
 *
 * @author Balika - BTL
 *
 * @ORM\Table(name="builder")
 * @ORM\Entity(repositoryClass="App\Repository\BuilderRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Builder extends Person implements \App\Model\BuilderInterface {

    /**
     * @ORM\Column(type="array")
     * 
     */
    protected $services;
    protected $builderTypes;
     /**
     *   @ORM\ManyToMany(targetEntity="Specialty")
     *   @ORM\JoinTable(name="builder_specialty",
     *   joinColumns={@ORM\JoinColumn(name="builder_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="specialty_id", referencedColumnName="id")})
     * */
    protected $builderSpecialties;

    public function __construct() {
        $this->ratingSummary = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->services = [];
        $this->builderTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->builderSpecialties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getPersonType() {
        return self::BUILDER;
    }

    public function getDefaultRole() {
        return self::BUILDER_ROLE;
    }

    /**
     * @var Category
     * @ORM\OneToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     * 
     */
    protected $profession;

    public function getProfession() {
        return $this->profession;
    }

    public function setProfession(Category $profession = null) {
        $this->profession = $profession;
        return $this;
    }

    /**
     * @var $ratingSummary
     *
     * @ORM\OneToMany(targetEntity="BuilderRatingSummary", mappedBy="builder", cascade={"persist"})
     */
    protected $ratingSummary;

    /**
     * @var $overallRating
     * @ORM\OneToOne(targetEntity="BuilderOverallRating", mappedBy="builder", cascade={"persist"})
     */
    protected $overallRating;

    /**
     * @ORM\OneToMany(
     *      targetEntity="BuilderRating",
     *      mappedBy="builder",       
     * )
     */
    protected $ratings;

    public function getOverallRating() {
        return $this->overallRating;
    }

    /**
     * Add addRating
     *
     * @param \App\Entity\BuilderRating $rating
     *
     * @return Company
     */
    public function addRating(BuilderRating $rating) {
        $this->ratings->add($rating);
        return $this;
    }

    /**
     * Remove removeRating
     *
     * @param \App\Entity\BuilderRating $rating
     */
    public function removeRating(BuilderRating $rating) {
        $this->ratingSummary->removeElement($rating);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings() {
        return $this->ratings;
    }

    /**
     * Add addRatingSummary
     *
     * @param \App\Entity\BuilderRatingSummary $ratingSummary
     *
     * @return Company
     */
    public function addRatingSummary(BuilderRatingSummary $ratingSummary) {
        $this->ratingSummary->add($ratingSummary);
        return $this;
    }

    /**
     * Remove removeRating
     *
     * @param \App\Entity\BuilderRatingSummary $rating
     */
    public function removeRatingSummary(BuilderRatingSummary $rating) {
        $this->ratingSummary->removeElement($rating);
    }

    public function setRatingSummary($ratingSummary) {
        $this->addRatingSummary($ratingSummary);
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatingSummary() {
        return $this->ratingSummary;
    }

    public function setOverallRating($overallRating) {
        $this->overallRating = $overallRating;
        return $this;
    }

    public function setRatings($ratings) {
        $this->addRating($ratings);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addService($service) {
        $service = strtoupper($service);
        if (!in_array($service, $this->getServices(), true)) {
            $this->services[] = $service;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeService($service) {
        if (false !== $key = array_search(strtoupper($service), $this->services, true)) {
            unset($this->services[$key]);
            $this->services = array_values($this->services);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices() {
        if ($this->services == null)
            $this->services = [];
        return array_unique($this->services);
    }

    public function setServices($services) {
        foreach ($services as $service) {
            $this->addService($service);
        }
        return $this;
    }

    public function getBuilderTypes(): \Traversable {
        if (empty($this->builderTypes)) {
            $this->builderTypes->add('ARTISAN');
            $this->builderTypes->add('PROFESSIONAL');
            $this->builderTypes->add('STUDENT');
        }
        return $this->builderTypes;
    }

    public function hasBuilderType($type): bool {
        return in_array(strtoupper($type), $this->getServices(), true);
    }

    /**
     * Add specialty
     *
     * @param Specialty $specialty
     *
     * @return Person
     */
    public function addSpecialty(Specialty $specialty) {
        if ($this->builderSpecialties == null) {
            $this->builderSpecialties = new ArrayCollection();
        }
        if (!$this->builderSpecialties->contains($specialty)) {
            $this->builderSpecialties[] = $specialty;
        }
        return $this;
    }

    /**
     * Remove specialty
     *
     * @param Specialty $specialty
     */
    public function removeSpecialty(Specialty $specialty) {
        $this->builderSpecialties->removeElement($specialty);
    }

}
