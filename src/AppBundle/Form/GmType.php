<?php

namespace AppBundle\Form;

use AppBundle\Entity\Era;
use AppBundle\Entity\Gm;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GmType extends AbstractType
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
        if($this->request->get('_route') == 'admin.gm.form'){
            $builder->add('image', FileType::class, [
                'data_class' => Gm::class,
                'constraints' => [
                    new NotBlank([
                        'message' => "Image vide"
                    ])
                ]
            ]);
        }else{
            $builder->add('image', FileType::class, [
                'required' => false,
                'data_class' => null,
                'data' => $entity->getImage()
            ])
            ;
        }
        $builder
            ->add('era', EntityType::class, [
                'class' => Era::class,
                'choice_label' => 'translations[fr].name',
                'placeholder' => 'Choisissez une ère'
            ])
        ;
        foreach ($this->locales as $key => $value) {
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
                ->add("description_$value", TextType::class, [
                    'mapped' => false,
                    'data' => $entity->translate($value)->getDescription(),
                    'constraints' => [
                        new NotBlank([
                            'message' => "Description_$value vide"
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
                $entity->translate($value)->setDescription($data["description_$value"]);
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
            'data_class' => 'AppBundle\Entity\GM'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gm';
    }


}
