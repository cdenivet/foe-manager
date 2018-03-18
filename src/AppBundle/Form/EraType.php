<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EraType extends AbstractType
{
    private $locales;

    public function __construct(ManagerRegistry $doctrine, $locales)
    {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Récupération des données du formulaire (par ex : entité)
        $entity = $builder->getData();

        foreach ($this->locales as $key => $value){
            $builder
                ->add("name_$value", TextType::class, [
                    'mapped' => false,
                    'data' => $entity->translate($value)->getName(),
                    'constraints' => [
                        new NotBlank([
                            'message' => "Name_$value vide"
                        ])
                    ]
                ])
            ;
        }

        //On crée un écouteur pour récupérer les saisies et les fusionner aux traductions
        $builder->addEventListener(FormEvents::PRE_SUBMIT,function (FormEvent $event){
            $data = $event->getData();
            $entity = $event->getForm()->getData();
            foreach ($this->locales as $key => $value){
                $entity->translate($value)->setName($data["name_$value"]);
            }
            $entity->mergeNewTranslations();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Era'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_era';
    }


}
