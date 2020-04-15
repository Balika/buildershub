<?php

namespace App\Menu;

#use Symfony\Component\DependencyInjection\ContainerAware;

use App\Entity\Supplier;
use App\Model\AppInterface;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use Knp\Menu\FactoryInterface;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PortalMenuBuilder {

    private $factory;
    private $doctrine;
    private $currentUser;
    private $categories;
    private $capitalCities;
    private $regions;
    private $appManager;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TokenStorageInterface $tokenStorage, Doctrine $doctrine, AppInterface $appManager) {
        $this->factory = $factory;
        $this->currentUser = $tokenStorage->getToken()->getUser();
        $this->doctrine = $doctrine;
        $this->appManager = $appManager;
    }

    public function createPortalMenu(RequestStack $requestStack) {
        $slug = $requestStack->getCurrentRequest()->get('slug');
        $activeCompany = $this->doctrine->getRepository(EntityConfig::COMPANY)->findOneBy(['slug' => $slug]);

        $company = $activeCompany instanceof Supplier ? $activeCompany : $this->getSupplier();
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'sidebar-menu')
                ->setChildrenAttribute('data-widget', 'tree');
        $menu->addChild('Dashboard', array('route' => 'store_admin_dashboard', 'routeParameters' => array('slug' => $company->getSlug())))
                ->setAttribute('class', 'first')
                ->setLabel('<i class="fa fa-dashboard"></i><span>Dashboard</span>')->setExtra('safe_label', true);

        $apps = $this->appManager->getApps(FALSE);//Get non-hubernize apps
        foreach ($apps as $app) {
            $parentMenu = $menu->addChild($app->getCode(), array('uri' => '#'))
                            ->setAttribute('class', 'treeview')
                            ->setChildrenAttributes(array('class' => 'treeview-menu'))
                            ->setLabel('<i class="' . $app->getIcon() . '"></i><span>' . $app->getLabel() . '</span><span class="pull-right-container"><i class="fa pull-right fa-angle-left"></i></span>')->setExtra('safe_label', true);
            foreach ($this->appManager->getAppMenus($app) as $menuItem) {
                $parentMenu->addChild($menuItem->getCode(), array('route' => $menuItem->getRoute(), 'routeParameters' => array('slug' => $company->getSlug())))
                        ->setLabel('<i class="fa fa-angle-double-right" aria-hidden="true"></i>' . $menuItem->getLabel())->setExtra('safe_label', true);
            }
        }
        $menu->addChild('Store_Options', array('route' => 'store_options', 'routeParameters' => array('slug' => $company->getSlug())))
                ->setAttribute('class', 'first')
                ->setLabel('<i class="fa fa fa-wrench"></i><span>Store Settings</span>')->setExtra('safe_label', true);
        return $menu;       
    }

    private function initProjectFilterMenu(RequestStack $requestStack) {
        if ($this->categories == null) {
            $this->categories = $this->doctrine->getRepository(Constants::EQUIPMENT_TYPE_ENTITY)->findAll();
        }
        if ($this->regions == null) {
            $this->regions = $this->doctrine->getRepository(Constants::REGION_ENTITY)->findAll();
        }
        if ($this->capitalCities == null) {
            $this->capitalCities = $this->doctrine->getRepository(Constants::TOWN_ENTITY)->findCapitalTowns();
        }
    }

    private function getSupplier() {
        $userCompanies = $this->currentUser->getUserCompanies();
        foreach ($userCompanies as $company) {
            if ($company instanceof Supplier)
                return $company;
        }
    }

}
