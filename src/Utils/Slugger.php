<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
/**
 * This class is used to provide an example of integrating simple classes as
 * services into a Symfony application.
 *
 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 */
class Slugger
{
    private $doctrine;
    public function __construct(Doctrine $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function slugify($string)
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(strip_tags($string))), '-');
    }
    public function slugifyUnique($string, $entity, $entityId=0)
    {
        $slug = $this->slugify($string);
        $instance = $this->doctrine->getRepository($entity)->findOneBy(array('slug'=>$slug));
        if($instance==null || $instance->getId()== $entityId ){//Returns slug if unique or represent same entity
            return $slug;
        }
        return $slug.'-'.date('h-s');
    }
}
