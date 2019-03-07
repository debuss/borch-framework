<?php
/**
 * @author    Alexandre D.
 * @copyright Copyright (c) 2019 Alexandre DEBUSSCHERE
 * @license   MIT
 */

namespace Borsch;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Emitter
 *
 * @package Borsch
 */
class Emitter
{
    /** @var ResponseInterface */
    protected $response;

    /** @var int */
    protected $response_chunk_size;

    /**
     * Emitter constructor.
     *
     * @param ResponseInterface $response
     * @param int $response_chunk_size
     */
    public function __construct(ResponseInterface $response, int $response_chunk_size = 4096)
    {
        $this->response = $response;
        $this->response_chunk_size = $response_chunk_size;
    }

    /**
     * Send headers and body from the response.
     *
     * @throws \RuntimeException
     */
    public function emit()
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Send headers.
     */
    public function sendHeaders()
    {
        if (!headers_sent()) {
            foreach ($this->response->getHeaders() as $header => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $header, $value));
                }
            }

            header(sprintf(
                'HTTP/%s %s %s',
                $this->response->getProtocolVersion(),
                $this->response->getStatusCode(),
                $this->response->getReasonPhrase()
            ), true, $this->response->getStatusCode());
        }
    }

    /**
     * Send body.
     *
     * @throws \RuntimeException
     */
    public function sendBody()
    {
        if ($this->response->getBody()->isReadable() && $this->response->getBody()->getSize()) {
            $this->response->getBody()->isSeekable() && $this->response->getBody()->rewind();
            $content_length = $this->response->getHeaderLine('Content-Length') ?:
                $this->response->getBody()->getSize();
            $echoed_length = 0;

            while (!$this->response->getBody()->eof()) {
                $content = $this->response->getBody()->read(min($content_length, $this->response_chunk_size));
                $echoed_length += mb_strlen($content);

                echo $content;

                if ($echoed_length >= $content_length || connection_status() != CONNECTION_NORMAL) {
                    break;
                }
            }
        }
    }
}
