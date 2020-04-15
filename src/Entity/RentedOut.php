<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseModel as Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Description of RentalAd
 *
 * @author RentalAd
 */

/**
 * @ORM\Table(name="rented_out")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable 
 */
class RentedOut extends Model {

    /**
     * @var string $remarks
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $remarks;

    /**
     * @var string $paymentStatus
     *
     * @ORM\Column(type="string")
     */
    protected $paymentStatus;

    /**
     * @var decimal $rentalRate
     *
     * @ORM\Column(type="decimal")
     */
    protected $rentalRate;

    /**
     * @var string $billingCycle
     *
     * @ORM\Column(type="string")
     */
    protected $billingCycle;

    /**
     * @var decimal $rentalDuration
     *
     * @ORM\Column(type="decimal")
     */
    protected $rentalDuration;

    /**
     * @var decimal $totalAmount
     *
     * @ORM\Column(type="decimal")
     */
    protected $totalAmount;
    
    /**
     * @var decimal $amountPaid
     *
     * @ORM\Column(type="decimal")
     */
    protected $amountPaid;

    /**
     * @var integer $quantity
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var boolean $isFullyPaid
     *
     * @ORM\Column(type="boolean")
     */
    protected $isFullyPaid;

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
    
    /**
     * @var datetime $datePaid
     *
     * @ORM\Column(type="datetime")
     */
    protected $datePaid;
    
     /**
     * @var datetime $paymentDueDate
     *
     * @ORM\Column(type="datetime")
     */
    protected $paymentDueDate;

    

    /**
     * @var string $agreementDocs
     *
     * @ORM\Column(type="string")
     * 
     */
    protected $agreementDocs;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_document", fileNameProperty="agreementDocs")
     * 
     * @var File
     */
    protected $attachmentFile;
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
     * @ORM\ManyToOne(targetEntity="Equipment")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    protected $equipment;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;
    
    /**
     * @var CompanyClient
     * @ORM\ManyToOne(targetEntity="CompanyClient")
     * @ORM\JoinColumn(name="rented_to", referencedColumnName="id")
     */
    protected $client;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $attachment
     *
     * @return Product
     */
    public function setAttachementFile(File $attachment = null) {
        $this->attachmentFile = $attachment;
        if ($attachment) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getAttachmentFile() {
        return $this->attachmentFile;
    }    
    public function getRemarks() {
        return $this->remarks;
    }

    public function getPaymentStatus() {
        return $this->paymentStatus;
    }

    public function getRentalRate(){
        return $this->rentalRate;
    }

    public function getBillingCycle() {
        return $this->billingCycle;
    }

    public function getRentalDuration() {
        return $this->rentalDuration;
    }

    public function getTotalAmount() {
        return $this->totalAmount;
    }

    public function getAmountPaid() {
        return $this->amountPaid;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getIsFullyPaid() {
        return $this->isFullyPaid;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getDatePaid(){
        return $this->datePaid;
    }

    public function getPaymentDueDate() {
        return $this->paymentDueDate;
    }

    public function getAgreementDocs() {
        return $this->agreementDocs;
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

    public function getClient() {
        return $this->client;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
        return $this;
    }

    public function setPaymentStatus($paymentStatus) {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }

    public function setRentalRate($rentalRate) {
        $this->rentalRate = $rentalRate;
        return $this;
    }

    public function setBillingCycle($billingCycle) {
        $this->billingCycle = $billingCycle;
        return $this;
    }

    public function setRentalDuration($rentalDuration) {
        $this->rentalDuration = $rentalDuration;
        return $this;
    }

    public function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function setAmountPaid($amountPaid) {
        $this->amountPaid = $amountPaid;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function setIsFullyPaid($isFullyPaid) {
        $this->isFullyPaid = $isFullyPaid;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function setDatePaid($datePaid) {
        $this->datePaid = $datePaid;
        return $this;
    }

    public function setPaymentDueDate($paymentDueDate) {
        $this->paymentDueDate = $paymentDueDate;
        return $this;
    }

    public function setAgreementDocs($agreementDocs) {
        $this->agreementDocs = $agreementDocs;
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

    public function setClient(CompanyClient $client) {
        $this->client = $client;
        return $this;
    }

        public function getDocumentName() {
        return 'rental_out_attachment' . $this->generateRandomString();
    }

}
