<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Exception;

/**
 * Description of MultipleFilesUploaderService
 *
 * @author Balika
 */
class MultipleFilesUploaderService {
    protected $s3;
    protected $bucket;
    protected $persistenceService;

    public function __construct(PersistenceService $persistenceService, $s3Client, $bucket) {
        $this->s3 = $s3Client;
        $this->bucket = $bucket;
        $this->persistenceService = $persistenceService;
    }

    public function uploadFiles($entity) {
        $galleryFiles = $entity->getGalleryFiles();
        $message = '';
        if ($galleryFiles != null && count($galleryFiles) > 0) {
            foreach ($galleryFiles as $file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $this->s3->putObject([
                        'Bucket' => $this->bucket,
                        'Key' => $fileName,
                        'SourceFile' => $file,
                    ]);
                    $entity->addGallery($fileName);
                    $message = "Images successfully uploaded";
                    $this->persistenceService->getEntityManager()->merge($entity);
                    $this->persistenceService->persist($entity);
                } catch (Exception $ex) {
                    $message = "Error uploading files to server " . $ex;
                }
            }
            $this->persistenceService->flush($entity);
        }
        return $message;
    }
}
