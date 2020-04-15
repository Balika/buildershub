<?php

namespace App\Admin;

use App\Entity\Region;
use App\Entity\Town;
use App\Utils\EntityConfig;
use App\Utils\Slugger;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TownAdmin
 *
 * @author Balika - MRH
 */
class TownAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Town Info', ['class' => 'col-md-7'])
                ->add('name', TextType::class)
                ->add('slug', TextType::class, ['required' => FALSE])
                ->add('region', EntityType::class, [
                    'class' => Region::class,
                    'placeholder' => 'Select Region'])
                ->add('parent', EntityType::class, array(
                'class' => Town::class,                
                'placeholder' => 'Select Parent Town',
                'attr' => ['data-select' => 'true'],
                'required' => false
            ))
                ->add('isCapital')
                ->add('isCity')
                ->add('isSparePartsHub')
                ->end();
       /** $regionFormModifier = function (FormInterface $form, Region $region = null) {
            $towns = null === $region ? array() : $region->getTowns();
            $form->add('parent', EntityType::class, array(
                'class' => Town::class,
                'choices' => $towns,
                'placeholder' => 'Select Parent Town',
                'attr' => ['data-select' => 'true'],
                'required' => false
            ));
        };

        $formMapper->getFormBuilder()->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($regionFormModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();
            $regionFormModifier($event->getForm(), $data !=null ? $data->getRegion() :null);
        });
        $formMapper->getFormBuilder()->get('region')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) use ($regionFormModifier) {
            // It's important here to fetch $event->getForm()->getData(), as
            // $event->getData() will get you the client data (that is, the ID)
            $region = $event->getForm()->getData();

            // since we've added the listener to the child, we'll have to pass on
            // the parent to the callback functions!
            $regionFormModifier($event->getForm()->getParent(), $region);
        }
        );*/
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('name')
                ->add('region');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('name')
                ->add('slug')
                ->add('region.name')
                ->add('isCapital')
                ->add('isCity')
                ->add('isSparePartsHub');
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::TOWN);
        $object->setSlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object) {
        parent::preUpdate($object);
        //$user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        //$object->setUser($user);
        $slug = $this->slugger->slugifyUnique($object->getName(), EntityConfig::TOWN, $object->getId());
        $object->setSlug($slug);
    }

    public function getSlugger() {
        return $this->slugger;
    }

    public function setSlugger(Slugger $slugger) {
        $this->slugger = $slugger;
        return $this;
    }

}
