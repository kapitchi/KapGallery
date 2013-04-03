<?php
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

