<?php

namespace Watson\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class LinkType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        

        $builder
            ->add('title', 'text')
            ->add('url', 'text')
            ->add('desc', 'text')
            ->add('tags', 'text');

    
    }

    public function getName()
    {
        return 'link';
    }

}
