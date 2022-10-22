<?php

namespace App\Form;

use App\Entity\Measures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasuresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Temperature')
            ->add('WindSpeed')
            ->add('WindDirection')
            ->add('Humidity', NumberType::class)
            ->add('PrecipationProbality',  NumberType::class)
            ->add('Date', DateType::class)
            ->add('localisation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measures::class,
        ]);
    }
}
