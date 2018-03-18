<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function listRoutes()
    {
        return [
          ['/fr/p/categorie0/produit28', 'produit28', 'En stock'],
          ['/en/p/category3/product23', 'product23', 'En stock'],
        ];
    }

    /**
     * @dataProvider listRoutes
     */
    public function testIndex(string $url, string $title, string $inStock)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains($title, $crawler->filter('.container h1')->text());
        $this->assertContains($inStock, $crawler->filter('.text-success')->text());
    }
}
