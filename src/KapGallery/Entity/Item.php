<?php
/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapGallery\Entity;

/*
 * 
 */

class Item
{
    protected $id;
    protected $name;
    protected $galleryId;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getGalleryId() {
        return $this->galleryId;
    }

    public function setGalleryId($galleryId) {
        $this->galleryId = $galleryId;
    }


    

}

