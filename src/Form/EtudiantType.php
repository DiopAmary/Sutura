<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Cotisation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ['attr' => ['class' => 'form-control'],])
            ->add('prenom', null, ['attr' => ['class' => 'form-control'],])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'masculin',
                    'Feminin' => 'feminin',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('paysOrigine', null, ['attr' => ['class' => 'form-control'],])
            ->add('nombreAnneeMaroc', null, ['attr' => ['class' => 'form-control'],])
            ->add('numTelephone', null, ['attr' => ['class' => 'form-control'],])
            ->add('villeEtude', null, ['attr' => ['class' => 'form-control'],])
            ->add('Etablissement', null, ['attr' => ['class' => 'form-control'],])
            ->add('Filiere', null, ['attr' => ['class' => 'form-control'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
