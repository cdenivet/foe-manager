<?php

namespace Tests\AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function listRoutes()
    {
        return [
          ['/fr/admin/', 'Tableau de bord'],
          ['/en/admin/', 'Administration pannel'],
        ];
    }

    /**
     * @dataProvider listRoutes
     */
    public function testRoutes(string $url, string $title)
    {
        // client : simule un navigateur
        $client = static::createClient([],[
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin'
        ]);

        //Suivre toute les redirections
        $client->followRedirects();

        $crawler = $client->request('GET', $url);      //DOM

        // assert : tests
        $this->assertEquals(200, $client->getResponse()->getStatusCode());  //Test de l'accès à la page
        $this->assertContains($title, $crawler->filter('h1')->text());  //Verification du titre

    }
}
