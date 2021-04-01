<?php

namespace App\Form;

use App\Entity\Pret;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            /* ->add('periode') */
            ->add('montant')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Santé' => 'sante',
                    'Loyer' => 'loyer',
                    'Alimentaire' => 'alimentaire',
                    'Autres' => 'autres',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('rib')
            ->add('commentaire');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pret::class,
        ]);
    }
}
