<?php

namespace Watson\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class LinkType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        

        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('url', 'text', array('label' => 'URL'))
            ->add('desc', 'text', array('label' => 'Description'))
            ->add('tags', 'text', array('label' => 'Tags'));

    
    }

    public function getName()
    {
        return 'link';
    }

}
