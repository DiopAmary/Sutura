<?php

namespace App\Form;

use App\Entity\Cotisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', null, ['attr' => ['class' => 'col-6 col-12-xsmall'],])
            /* ->add('periode',IntegerType::class,['attr'=>['class'=>'col-6 col-12-xsmall'],]) */
            ->add('justificatif', FileType::class, ['data_class' => null, 'attr' => ['class' => 'col-6 col-12-xsmall'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cotisation::class,
        ]);
    }
}
