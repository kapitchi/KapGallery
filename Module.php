<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
                        $sm->get('KapGallery\Entity\Gallery'),
                        $sm->get('KapGallery\Entity\GalleryHydrator'),
                       'gallery'
                    );
                },
                'KapGallery\Entity\GalleryHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapGallery\Form\Gallery' => function ($sm) {
                    $ins = new Form\Gallery('gallery');
                    $ins->setInputFilter($sm->get('KapGallery\Form\GalleryInputFilter'));
                    return $ins;
                },
                'KapGallery\Form\GalleryInputFilter' => function ($sm) {
                    $ins = new Form\GalleryInputFilter();
                    return $ins;
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
                        $sm->get('KapGallery\Entity\Item'),
                        $sm->get('KapGallery\Entity\ItemHydrator'),
                        'gallery_item'
                    );
                },
                'KapGallery\Entity\ItemHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapGallery\Entity\GalleryHydrator' => function ($sm) {
                    //needed here because hydrator tranforms camelcase to underscore
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
                'KapGallery\Form\Item' => function ($sm) {
                    $ins = new Form\Item('item');
                    $ins->setInputFilter($sm->get('KapGallery\Form\ItemInputFilter'));
                    return $ins;
                },
                'KapGallery\Form\ItemInputFilter' => function ($sm) {
                    $ins = new Form\ItemInputFilter();
                    return $ins;
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