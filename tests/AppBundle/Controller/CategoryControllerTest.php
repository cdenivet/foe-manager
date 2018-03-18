<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function listRoutes()
    {
        return [
          ['/fr/c/categorie2', 'catégorie2'],
          ['/en/c/category2', 'category2'],
        ];
    }

    /**
     * @dataProvider listRoutes
     */
    public function testIndex(string $url, string $title)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains($title, $crawler->filter('.container h1')->text());
        $this->assertGreaterThan(1, $crawler->filter('.col-sm-4')->count());
    }
}
