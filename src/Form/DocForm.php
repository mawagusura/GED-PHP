<?php
/**
 * Created by PhpStorm.
 * User: LUCASMasson
 * Date: 13/07/2018
 * Time: 16:04
 */

namespace App\Form;

use App\Entity\Docs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DocForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('doc_name',TextType::class)
            ->add('description',TextType::class)
            ->add('doc_tags', TextType::class)
            ->add('doc_doc_type_id',ChoiceType::class,array(
                'types' => array(

                )
            ))
            ->add('doc_data', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Docs::class,
        ));
    }
}