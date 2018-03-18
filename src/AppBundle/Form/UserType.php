<?php

namespace AppBundle\Form;

use AppBundle\EventSubscriber\UserTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    private $requestStack;
    private $request;


    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getMasterRequest();
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'username.notblank'
                    ]),
                    new Regex([
                        'message' => 'username.regex',
                        'pattern' => "/^[a-zA-Z '-]+$/"
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'password.notblank'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'email.notblank'
                    ]),
                    new Email([
                        'message' => 'email.incorrect',
                        'checkHost' => true,
                        'checkMX' => true
                    ])
                ]
            ])
            ->add('adress', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'adress.notblank'
                    ])
                ]
            ])
            ->add('zipCode', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'zipCode.notblank'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'city.notblank'
                    ])
                ]
            ])
            ->add('country', CountryType::class, [
                'placeholder' => 'Choisissez votre pays',
                'constraints' => [
                    new NotBlank([
                        'message' => 'country.notblank'
                    ])
                ]
            ])
        ;

        $subscriber = new UserTypeSubscriber($this->requestStack);
        $builder->addEventSubscriber($subscriber);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event){
            //Récupérer le nom de la route
            $route = $this->request->get('_route');
            if($route === "account.signup"){
                $data = $event->getData();
                $event->getForm()
                    ->remove('adress')
                    ->remove('zipCode')
                    ->remove('city')
                    ->remove('country')
                ;
            }
        });
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
