<?php
/**
 * @author    Alexandre D.
 * @copyright Copyright (c) 2019 Alexandre DEBUSSCHERE
 * @license   MIT
 */

namespace Borsch;

use League\Route\{Router, Http\Exception\HttpExceptionInterface};
use Nyholm\Psr7Server\ServerRequestCreator;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class App
 *
 * @package Borsch
 */
class App extends Router
{

    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function run()
    {
        $request = (new ServerRequestCreator(
            Factory::getFactory(),
            Factory::getFactory(),
            Factory::getFactory(),
            Factory::getFactory()
        ))->fromGlobals();

        try {
            $response = $this->dispatch($request);
        } catch (HttpExceptionInterface $exception) {
            $response = Factory::createResponse(
                $exception->getStatusCode(),
                $exception->getMessage()
            );

            foreach ($exception->getHeaders() as $header => $value) {
                $response = $response->withHeader($header, $value);
            }
        }

        $emitter = new Emitter($response);
        $emitter->emit();
    }
}
