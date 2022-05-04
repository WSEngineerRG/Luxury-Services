<?php

namespace App\Form;

use App\Entity\Candidates;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('gender', ChoiceType::class,[
                'choices'  => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                ],
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('country')
            ->add('nationality')
            ->add('passport', FileType::class, [
                'label' => 'passport img',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => "image/png, image/jpeg, image/jpg",
                ]
            ])
            ->add('cv', FileType::class, [
                'label' => 'cv (PDF file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('profilPicture', FileType::class,[
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => "image/png, image/jpeg, image/jpg",
                ]
            ])
            ->add('currentLocation')
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('placeOfBirth')
            ->add('shortDescription')
            ->add('jobCategory', EntityType::class,[
                'class' => "App\Entity\JobCategory"
            ])
            ->add('experience', EntityType::class,[
                'class' => "App\Entity\Experience"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidates::class,
        ]);
    }
}