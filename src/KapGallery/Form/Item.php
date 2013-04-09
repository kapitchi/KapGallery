<?php

namespace KapGallery\Form;

use KapitchiBase\Form\EventManagerAwareForm;

class Item extends EventManagerAwareForm
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        
        
    }
    
}