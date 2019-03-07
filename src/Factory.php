<?php
/**
 * @author    Alexandre D.
 * @copyright Copyright (c) 2019 Alexandre DEBUSSCHERE
 * @license   MIT
 */

namespace Borsch;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class Factory
 *
 * @package Borsch
 */
class Factory
{

    /** @var Psr17Factory */
    protected static $factory;

    /**
     * @return Psr17Factory
     */
    public static function getFactory(): Psr17Factory
    {
        if (!self::$factory) {
            self::$factory = new Psr17Factory();
        }

        return self::$factory;
    }

    /**
     * @param string $method
     * @param $uri
     * @return RequestInterface
     */
    public static function createRequest(string $method, $uri): RequestInterface
    {
        return self::getFactory()->createRequest($method, $uri);
    }

    /**
     * @param int $code
     * @param string $reason_phrase
     * @return ResponseInterface
     */
    public static function createResponse(int $code = 200, string $reason_phrase = ''): ResponseInterface
    {
        return self::getFactory()->createResponse($code, $reason_phrase);
    }

    /**
     * @param string $content
     * @return StreamInterface
     */
    public static function createStream(string $content = ''): StreamInterface
    {
        return self::getFactory()->createStream($content);
    }

    /**
     * @param string $filename
     * @param string $mode
     * @return StreamInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return self::getFactory()->createStreamFromFile($filename, $mode);
    }

    /**
     * @param $resource
     * @return StreamInterface
     */
    public static function createStreamFromResource($resource): StreamInterface
    {
        return self::getFactory()->createStreamFromResource($resource);
    }

    /**
     * @param StreamInterface $stream
     * @param int|null $size
     * @param int $error
     * @param string|null $client_filename
     * @param string|null $client_media_type
     * @return UploadedFileInterface
     * @throws \InvalidArgumentException
     */
    public static function createUploadedFile(StreamInterface $stream, int $size = null, int $error = \UPLOAD_ERR_OK, string $client_filename = null, string $client_media_type = null): UploadedFileInterface
    {
        return self::getFactory()->createUploadedFile($stream, $size, $error, $client_filename, $client_media_type);
    }

    /**
     * @param string $uri
     * @return UriInterface
     * @throws \InvalidArgumentException
     */
    public static function createUri(string $uri): UriInterface
    {
        return self::getFactory()->createUri($uri);
    }

    /**
     * @param string $method
     * @param $uri
     * @param array $server_params
     * @return ServerRequestInterface
     */
    public static function createServerRequest(string $method, $uri, array $server_params = []): ServerRequestInterface
    {
        return self::getFactory()->createServerRequest($method, $uri, $server_params);
    }
}
