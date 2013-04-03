<?php

namespace KapGallery;

use Zend\ModuleManager\Feature\ControllerProviderInterface,
    Zend\EventManager\EventInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    Zend\ModuleManager\Feature\ViewHelperProviderInterface,
    KapitchiBase\ModuleManager\AbstractModule,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions,
    KapitchiEntity\Mapper\EntityDbAdapterMapper;

class Module extends AbstractModule implements ServiceProviderInterface, ControllerProviderInterface, ViewHelperProviderInterface {

    public function onBootstrap(EventInterface $e) {
        parent::onBootstrap($e);
    }

    public function getControllerConfig() {
        return array(
            'factories' => array(
                //API
                    //Gallery
                'KapGallery\Controller\Api\Gallery' => function($sm) {
                    $cont = new Controller\Api\GalleryRestfulController(
                        $sm->getServiceLocator()->get('KapGallery\Service\Gallery')
                    );
                    return $cont;
                },
                     //Item
                 'KapGallery\Controller\Api\Item' => function($sm) {
                    $cont = new Controller\Api\ItemRestfulController(
                        $sm->getServiceLocator()->get('KapGallery\Service\Item')
                    );
                    return $cont;
                },
                   
            )
        );
    }

    public function getViewHelperConfig() {
        return array(
             'factories' => array(
                //gallery
                'gallery' => function($sm) {
                    $ins = new View\Helper\Gallery(
                        $sm->getServiceLocator()->get('KapGallery\Service\Gallery')
                    );
                    return $ins;
                },
                //item
                'galleryItem' => function($sm) {
                    $ins = new View\Helper\Item(
                        $sm->getServiceLocator()->get('KapGallery\Service\Item')
                    );
                    return $ins;
                },
                
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'KapGallery\Entity\Gallery' => 'KapGallery\Entity\Gallery',
                'KapGallery\Entity\Item' => 'KapGallery\Entity\Item'
            ),
            'factories' => array(
                //Gallery
                'KapGallery\Service\Gallery' => function ($sm) {
                    $s = new Service\Gallery(
                        $sm->get('KapGallery\Mapper\GalleryDbAdapter'),
                        $sm->get('KapGallery\Entity\Gallery'),
                        $sm->get('KapGallery\Entity\GalleryHydrator')
                    );
                    return $s;
                },
                'KapGallery\Mapper\GalleryDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'gallery',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapGallery\Entity\GalleryHydrator'),
                            'entityPrototype' => $sm->get('KapGallery\Entity\Gallery'),
                        ))
                    );
                },
                'KapGallery\Entity\GalleryHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
               //Item
                'KapGallery\Service\Item' => function ($sm) {
                    $s = new Service\Gallery(
                        $sm->get('KapGallery\Mapper\ItemDbAdapter'),
                        $sm->get('KapGallery\Entity\Item'),
                        $sm->get('KapGallery\Entity\ItemHydrator')
                    );
                    return $s;
                },
                'KapGallery\Mapper\ItemDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'gallery_item',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapGallery\Entity\ItemHydrator'),
                            'entityPrototype' => $sm->get('KapGallery\Entity\Item'),
                        ))
                    );
                },
                'KapGallery\Entity\ItemHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
            )
        );
    }

    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}