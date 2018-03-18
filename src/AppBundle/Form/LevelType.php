<?php

namespace AppBundle\Form;

use AppBundle\Entity\Era;
use AppBundle\Entity\Gm;
use AppBundle\Entity\Level;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LevelType extends AbstractType
{
    private $doctrine;
    private $locales;
    private $request;

    public function __construct(ManagerRegistry $doctrine, RequestStack $requestStack, $locales)
    {
        $this->doctrine = $doctrine;
        $this->locales = $locales;
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Récupération des données du formulaire (par ex : entité)
        $entity = $builder->getData();
        $builder
            ->add('gm', EntityType::class, [
                'class' => Gm::class,
                'choice_label' => 'translations[fr].name',
                'placeholder' => 'Choisissez un GM'
            ])
            ->add("level", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getLevel(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Niveau vide"
                    ])
                ]
            ])
            ->add("totalPF", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getTotalPF(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Total PF vide"
                    ])
                ]
            ])
            ->add("rewardP1", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getRewardP1(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Récompense P1 vide"
                    ])
                ]
            ])
            ->add("rewardP2", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getRewardP2(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Récompense P2 vide"
                    ])
                ]
            ])
            ->add("rewardP3", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getRewardP3(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Récompense P3 vide"
                    ])
                ]
            ])
            ->add("rewardP4", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getRewardP4(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Récompense P4 vide"
                    ])
                ]
            ])
            ->add("rewardP5", IntegerType::class, [
                'mapped' => true,
                'data' => $entity->getRewardP5(),
                'constraints' => [
                    new NotBlank([
                        'message' => "Récompense P5 vide"
                    ])
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Level'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_level';
    }


}
