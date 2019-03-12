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

class Request
{
    /**
     * Initial url
     *
     * @var null|string
     */
    protected $url;

    /**
     * Default options
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Dynamic options
     *
     * @var array
     */
    protected $options = [];

    /**
     * CURL constructor.
     *
     * @param null|string $url
     * @param null|array  $defaults
     *
     * @see curl_init
     */
    public function __construct($url = null, array $defaults = [])
    {
        $this->url      = $url;
        $this->defaults = $defaults;
    }

    /**
     * Set url
     *
     * @param null|string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set defaults
     *
     * @param array $defaults
     */
    public function setDefaults(array $defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * Get defaults
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Set dynamic option
     *
     * @param int   $option
     * @param mixed $value
     *
     * @see curl_setopt
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * Set many dynamic options at once
     *
     * @param array $option
     *
     * @see curl_setopt_array
     */
    public function setOptions(array $option = [])
    {
        foreach ($option as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    /**
     * Get dynamic options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get curl library version
     *
     * @param null|int $age
     *
     * @return array
     *
     * @see curl_version
     */
    public function getCURLVersion($age = null)
    {
        return curl_version($age);
    }

    /**
     * Execute request and return response
     *
     * @return Response
     */
    public function execute()
    {
        $options = $this->defaults;

        if (null !== $this->url) {
            $options[CURLOPT_URL] = $this->url;
        }

        $options = array_replace(
            $options,
            $this->options,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLINFO_HEADER_OUT    => true,
            ]
        );

        $session = curl_init();

        curl_setopt_array($session, $options);

        $result  = curl_exec($session);
        $info    = curl_getinfo($session);
        $code    = (int) $info['http_code'];
        $headers = trim(substr($result, 0, $info['header_size']));
        $body    = trim(substr($result, $info['header_size']));
        $error   = curl_error($session);

        curl_close($session);

        unset($info['http_code'], $info['header_size']);

        if ($error) {
            throw new Exception\CURLException($error);
        }

        return new Response($body, $code, $headers, $info);
    }
}