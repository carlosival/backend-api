<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/03/17
 * Time: 22:53
 */

namespace DietaBundle\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;
use Guzzle\Http\Message\AbstractMessage;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\History\HistoryPlugin;
use Symfony\Component\Console\Helper\FormatterHelper
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DomCrawler\Crawler;


class ApiTestCase extends KernelTestCase
{

    /**
     * @var Client
     */
    private static $staticClient;


    /**
     * @var History
     */
    private static $history;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var FormatterHelper
     */
    private $formatterHelper;




    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_url' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        self::$history = new HistoryPlugin();
        self::$staticClient->
            ->attach(self::$history);

        self::bootKernel();
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }
    /**
     * Clean up Kernel usage in this test.
     */
    protected function tearDown()
    {
        // purposefully not calling parent class, which shuts down the kernel
    }
    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine.orm.default_entity_manager'));
        $purger->purge();
    }
    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
    }


}