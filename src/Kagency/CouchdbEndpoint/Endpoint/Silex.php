<?php

namespace Kagency\CouchdbEndpoint\Endpoint;

use Kagency\CouchdbEndpoint\Endpoint;
use Kagency\CouchdbEndpoint\Container;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Silex extends Endpoint
{
    /**
     * Silex application
     *
     * @var \Silex\Application
     */
    protected $app;

    /**
     * Dependency Injection Container
     *
     * @var Container
     */
    protected $container;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Container $container, $name = "storage")
    {
        $this->app = new \Silex\Application();
        $controller = new Silex\Controller(
            $container['replicator']
        );

        $this->app->get("/{database}/", array($controller, 'getDatabaseStatus'));
        $this->app->get("/{database}/_local/{revision}", array($controller, 'hasChange'));
    }

    /**
     * Run endpoint
     *
     * @return void
     */
    public function run()
    {
        $this->app->run();
    }

    /**
     * Test run
     *
     * Method used to not fully run Silex, but execute the tests with a given
     * Request and return the created Reponse object for comparision.
     *
     * @param Request $request
     * @return Response
     */
    public function testRun(Request $request)
    {
        return $this->app->handle($request);
    }
}