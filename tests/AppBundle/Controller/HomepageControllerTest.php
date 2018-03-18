<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function listRoutes()
    {
        return [
          ['/fr/', 'Catégorie'],
          ['/en/', 'Category'],
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
        $this->assertContains($title, $crawler->filter('.container > .row:nth-of-type(2) h1')->text());
        $this->assertGreaterThan(0,$crawler->filter('.container > .row:nth-of-type(2) .btn')->count());
        $this->assertEquals(3,$crawler->filter('.container > .row:nth-of-type(3) h2')->count());
        $this->assertFalse($crawler->filter('.container > .row:nth-of-type(3) h2')->count() != 3);
    }
}
