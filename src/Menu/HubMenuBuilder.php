<?php

namespace App\Menu;

#use Symfony\Component\DependencyInjection\ContainerAware;


use App\Model\AppInterface;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class HubMenuBuilder {

    private $factory;
    private $doctrine;
    private $currentUser;
    private $appManager;
    private $capitalCities;
    private $regions;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TokenStorageInterface $tokenStorage, Doctrine $doctrine, AppInterface $appManager) {
        $this->factory = $factory;
        $this->currentUser = $tokenStorage->getToken()->getUser();
        $this->doctrine = $doctrine;
        $this->appManager = $appManager;
    }

    public function createHubMenu(RequestStack $requestStack) {
       // $domain = $this->appManager->getCurrentDomain();
            //$requestStack->getCurrentRequest()->get('slug');
       // $company = $this->doctrine->getRepository(EntityConfig::COMPANY)->findOneBy(['domain' => $domain]);
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'sidebar-menu')
                ->setChildrenAttribute('data-widget', 'tree');
        $menu->addChild('Dashboard', array('route' => 'hubernize_dashboard'))
                ->setAttribute('class', 'first')
                ->setLabel('<i class="fa fa-dashboard"></i><span>Dashboard</span>')->setExtra('safe_label', true);

        $apps = $this->appManager->getApps();
        foreach ($apps as $app) {
            $parentMenu = $menu->addChild($app->getCode(), array('uri' => '#'))
                            ->setAttribute('class', 'treeview')
                            ->setChildrenAttributes(array('class' => 'treeview-menu'))
                            ->setLabel('<i class="' . $app->getIcon() . '"></i><span>' . $app->getLabel() . '</span><span class="pull-right-container"><i class="fa pull-right fa-angle-left"></i></span>')->setExtra('safe_label', true);
            foreach ($this->appManager->getAppMenus($app) as $menuItem) {
                $parentMenu->addChild($menuItem->getCode(), array('route' => $menuItem->getRoute()))
                        ->setLabel('<i class="fa fa-angle-double-right" aria-hidden="true"></i>' . $menuItem->getLabel())->setExtra('safe_label', true);
            }
        }
        return $menu;
    }

}
