<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre'
            ])
            ->add('description', null, [
                'label' => 'Description'
            ])
            ->add('surface', null, [
                'label' => 'Surface'
            ])
            ->add('rooms', null, [
                'label' => 'Pièces'
            ])
            ->add('bedrooms', null, [
                'label' => 'Chambres'
            ])
            ->add('floor', null, [
                'label' => 'Etage'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Chauffage'
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('imageFile', FileType::class, [
                'required'  => false
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('adress', null, [
                'label' => 'Adresse'
            ])
            ->add('postal_code', null, [
                'label' => 'Code postal'
            ])
            ->add('sold', null, [
                'label' => 'Vendu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoices(){
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
