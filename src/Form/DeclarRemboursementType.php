<?php

namespace App\Form;

use App\Entity\DeclarRemboursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use    Symfony\Component\Validator\Constraints\NotBlank;

class DeclarRemboursementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            /* ->add('periode')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Santé' => 'Santé',
                    'Loyer' => 'Loyer',
                    'Autres' => 'autres',
                ],
                'attr' => ['class' => 'form-control'],
            ]) */
            ->add('justificatif', FileType::class, ['data_class' => null, 'attr' => ['class' => 'col-6 col-12-xsmall'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarRemboursement::class,
        ]);
    }
}
