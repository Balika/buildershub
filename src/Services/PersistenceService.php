<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\EntityImage;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Work;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use App\Utils\ImageProcessor;
use App\Utils\Slugger;
use Doctrine\Persistence\ManagerRegistry as Doctrine;

class PersistenceService {

    /**
     *
     * @var Doctrine 
     */
    protected $doctrine;
    private $entityManager;
    private $rootDir;
    private $imageProcessor;
    private $slugger;

    const ENTITIES_SORTER_FUNCTION = "sortEntities";

    public function __construct(Doctrine $doctrine, ImageProcessor $imageProcessor, Slugger $slugger, $rootDir) {
        $this->doctrine = $doctrine;
        $this->rootDir = $rootDir;
        $this->imageProcessor = $imageProcessor;
        $this->entityManager = $doctrine->getManager();
        $this->slugger = $slugger;
    }

    public function saveSnapshare(SnapShare $snapshare) {
        $slugifiedName = $this->slugger->slugify($snapshare->getTitle());
        $snapshare->setSlug($slugifiedName);
        $this->saveEntityWithPhotos($snapshare, Constants::CONTENT_UPLOAD_DIR);
    }

    public function saveConversation(Conversation $conversation) {
        $slugifiedName = $this->slugger->slugify($conversation->getTopic());
        $conversation->setSlug($slugifiedName);
        $this->saveEntityWithPhotos($conversation, Constants::CONTENT_UPLOAD_DIR);
    }

    public function saveWork(Work $work) {
        $slug = $this->slugger->slugifyUnique($work->getTitle(), Constants::WORK_ENTITY);
        $work->setSlug($slug);
        $this->saveEntityWithPhotos($work, Constants::CONTENT_UPLOAD_DIR);
    }

    public function saveStoreEntity($entity) {
        $slug = $this->slugger->slugifyUnique($entity->getName(), $entity instanceof Product ? EntityConfig::PRODUCT : EntityConfig::PRODUCT_CATEGORY, $entity->getId());
        $entity->setSlug($slug);
        $this->saveEntity($entity);
        //$this->saveEntityWithPhotos($entity, Constants::PRODUCT_UPLOAD_DIR);
    }

    public function saveAward(Award $award) {
        $slug = $this->slugger->slugifyUnique($award->getName(), Constants::AWARD_ENTITY);
        $award->setSlug($slug);
        $this->saveEntityWithPhotos($award, Constants::CONTENT_UPLOAD_DIR);
    }

    public function saveRentalAd(RentalAdverts $ad) {
        $slug = $this->slugger->slugifyUnique($ad->getName(), Constants::RENTAL_ADVERTS_ENTITY);
        $ad->setSlug($slug);
        $this->saveEntityWithPhotos($ad, Constants::EQUIPMENT_UPLOAD_DIR);
    }

    public function savePost(Post $post) {
        $slug = $this->slugger->slugifyUnique($post->getTitle(), Constants::POST_ENTITY);
        $post->setSlug($slug);
        $this->saveEntityWithPhotos($post, Constants::CONTENT_UPLOAD_DIR);
    }

    public function saveEntityPhotos($user, $entity, $entityId, $photo, $caption = null, $photos = null) {
        if ($photo != null) {
            $fileName = $this->imageProcessor->processSingleImage($this->rootDir, Constants::CONTENT_UPLOAD_DIR, $photo);
            $entityPhoto = new EntityImage($entity, $entityId, $user, $fileName, $caption);
            $this->persist($entityPhoto);
        }
        if ($photos != null || count($photos) > 0) {
            foreach ($photos as $photo) {
                $fileName = $this->imageProcessor->processSingleImage($this->rootDir, Constants::CONTENT_UPLOAD_DIR, $photo);
                $entityPhoto = new EntityImage($entity, $entityId, $user, $fileName, $caption);
                $this->persist($entityPhoto);
            }
        }
        $this->flush();
    }

    public function saveEntity($entity) {
        $this->persist($entity);
        $this->flush();
    }

    public function persist($entity) {       
        $this->entityManager->persist($entity);
    }

    public function flush() {
        $this->entityManager->flush();       
    }

    public function deleteEntity($entity) {
        $this->remove($entity);
        $this->flush();
    }

    public function remove($entity) {
        $this->entityManager->remove($entity);
    }

    

    public function saveEntities($entities) {
        foreach ($entities as $entity) {
            $this->persist($entity);
        }
        $this->flush();
    }

    public function deleteEntities($entities) {
        foreach ($entities as $entity) {
            $this->remove($entity);
        }
        $this->flush();
    }

    public function softDeleteEntities($entities) {
        foreach ($entities as $entity) {
            $entity->setDeleted(true);
            $this->persist($entity);
        }
        $this->flush();
    }

    public function softDeleteEntity($entity) {
        $entity->setDeleted(true);
        $this->persist($entity);
        $this->flush();
    }

    private function saveEntityWithPhotos($entity, $uploadDir) {
        //$imageFile = $entity->getImageFile();
       /** if ($imageFile != null) {
            $fileName = $this->imageProcessor->processSingleImage($this->rootDir, $uploadDir, $imageFile);
            $entity->setFeatureImage($fileName);
        }*/
        if (!($entity instanceof ProductCategory)) {
            $imageFiles = $entity->getGalleryFiles();
            if ($imageFiles != null || count($imageFiles) > 0) {
                $imageGallery = $this->imageProcessor->processGallery($this->rootDir, $uploadDir, $imageFiles);
                $entity->setGallery($imageGallery);
            }
        }
        $this->saveEntity($entity);
    }

    public function saveCompany(Company $company) {
        $imageFile = $company->getImageFile();
        if ($imageFile != null) {
            $fileName = $this->imageProcessor->processSingleImage($this->rootDir, Constants::LOGOS_UPLOAD_DIR, $imageFile);
            $company->setlogo($fileName);
        }
        $this->saveEntity($company);
    }
    public function getDoctrine(){
        return $this->doctrine;
    }
    public function getRepository($entity){
        return $this->doctrine->getRepository($entity);
    }

    public function isManagedEntity($entity){
        return $this->doctrine->getEntityManager()->contains($entity);
       
    }
    public function getEntityManager() {
        return $this->entityManager;
    }


}
