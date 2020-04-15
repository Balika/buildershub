<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of ImageProcessor
 *
 * @author Balika - MRH
 */
class ImageProcessor {
   public function processGallery($rootDir, $uploadDir, $uploadedFiles) {
        $filenames = array();
        foreach ($uploadedFiles as $file) {
           $fileName= $this->processSingleImage($rootDir, $uploadDir, $file) ;   
            $filenames[] = $fileName;                 
        }
        return $filenames;
    }
    public function processSingleImage($rootDir, $uploadDir, $file) {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();       
        // Move the file to the directory where brochures are stored        
        $file->move(
                realpath($rootDir) . $uploadDir, $fileName
        );        
        return $fileName;
    }
}
