<?php

namespace Teo\Db18nBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class LabelAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('translations', 'a2lix_translations', array(
                'locales' => array('it', 'en', 'de', 'fr'),
                'default_locale' => 'en'
                ))
            ;

        // $formMapper->add('translations', 'a2lix_translations', array(
        //     'required' => false,
        //     'fields' => array(
        //         'content' => array(
        //             'attr' => array(
        //                 'class' => 'translation-textarea'
        //             )
        //         )
        //     )
        // ));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('translations', null, array(
                'template' => 'TeoDb18nBundle:Admin:label_translation.html.twig'
            ))
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'TeoDb18nBundle:Admin:edit_label.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}