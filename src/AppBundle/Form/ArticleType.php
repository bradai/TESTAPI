<?php
/**
 * Created by PhpStorm.
 * User: fhm
 * Date: 27/11/16
 * Time: 23:21
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ArticleType  extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', ['required' => true , 'description'=>'title'])
            ->add('leading', 'text', ['required' => false , 'description'=>'leading'])
            ->add('body', 'text', ['required' => true , 'description'=>'body'])
            ->add('createdBy','text',['required' => true ,'description'=>'createdBy'])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }


} 