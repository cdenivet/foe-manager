<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    public function listRoutes()
    {
        return [
          ['/fr/signup', 'Créer un compte', 'Valider', 'Connexion'],
          ['/en/signup', 'Create an account', 'Validate', 'Connection'],
        ];
    }

    /**
     * @dataProvider listRoutes
     */
    public function testRoutes(string $url, string $title, string $validateButton, string $titleSecondaryPage)
    {
        // client : simule un navigateur
        $client = static::createClient();

        //Suivre toute les redirections
        $client->followRedirects();

        $crawler = $client->request('GET', $url);      //DOM

        // assert : tests
        $this->assertEquals(200, $client->getResponse()->getStatusCode());  //Test de l'accès à la page
        $this->assertContains($title, $crawler->filter('h1')->text());  //Verification du titre

        //Générer une chaine de caractere aléatoir pour avoir un user unique et passer la contrainte de formulaire REGEX
        $chaine = 'abcdefghijklmnopqrstuvwxyz';
        $nb_lettres = strlen($chaine) - 1;
        $rand = '';
        for($i=0; $i < 15; $i++)
        {
            $pos = mt_rand(0, $nb_lettres);
            $car = $chaine[$pos];
            $rand .= $car;
        }

        $formData = [
            'appbundle_user[username]' => 'user-'.$rand,
            'appbundle_user[password]' => 'user',
            'appbundle_user[email]' => 'user'.time().'@gmail.com'
        ];

        //On rempli le formulaire avrec les données
        $form = $crawler->selectButton($validateButton)->form($formData);

        //On soumet le formulaire : METTRE A JOUR LE DOM
        $crawler = $client->submit($form);

        //Tests sur la page d'atterissage
        $this->assertEquals(200, $client->getResponse()->getStatusCode());  //Test de l'accès à la page
        $this->assertContains($titleSecondaryPage, $crawler->filter('h1')->text());  //Verification du titre
    }
}
