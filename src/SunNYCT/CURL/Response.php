<?php
/**
 * SunNY Creative Technologies
 *
 *   #####                                ##     ##    ##      ##
 * ##     ##                              ###    ##    ##      ##
 * ##                                     ####   ##     ##    ##
 * ##           ##     ##    ## #####     ## ##  ##      ##  ##
 *   #####      ##     ##    ###    ##    ##  ## ##       ####
 *        ##    ##     ##    ##     ##    ##   ####        ##
 *        ##    ##     ##    ##     ##    ##    ###        ##
 * ##     ##    ##     ##    ##     ##    ##     ##        ##
 *   #####        #######    ##     ##    ##     ##        ##
 *
 * C  R  E  A  T  I  V  E     T  E  C  H  N  O  L  O  G  I  E  S
 */

namespace SunNYCT\CURL;

use SunNYCT\CURL\Exception;

/**
 * Response
 */
class Response
{
    /**
     * Body string
     *
     * @var string
     */
    public $body;

    /**
     * Status code
     *
     * @var int
     */
    public $code;

    /**
     * Headers
     *
     * @var array
     */
    public $headers = [];

    /**
     * Raw response info
     *
     * @var array
     */
    public $info = [];

    /**
     * Response constructor.
     *
     * @param string $body
     * @param int    $code
     * @param array  $headers
     * @param array  $info
     */
    public function __construct($body = '', $code = 200, $headers = [], array $info = [])
    {
        $this->body = (string) $body;
        $this->code = (int) $code;

        $this->headers = is_string($headers) ? $this->parseHeaders($headers) : $headers;
        $this->info    = $info;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $headers
     *
     * @return array
     */
    protected function parseHeaders($headers)
    {
        if (is_string($headers)) {
            $temp    = explode("\n", $headers);
            $headers = [];

            foreach ($temp as $line) {
                $line = array_map('trim', explode(':', $line, 2));
                if (isset($line[0], $line[1]) && $line[0] && $line[1]) {
                    $headers[$line[0]] = $line[1];
                }
            }
        } elseif (!is_array($headers)) {
            throw new Exception\InvalidArgumentException(
                'Cannot parse headers from ' . is_object($headers)
                    ? get_class($headers)
                    : gettype($headers)
            );
        }

        return $headers;
    }
}