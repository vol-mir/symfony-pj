<?php

namespace App\Service\Parser\Transport;

/**
 * Class Curl
 * @package App\Service\Parser\Transport
 */
class Curl implements TransportInterface
{
    /** @var resource */
    private $curl;

    /**
     * Curl constructor
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Curl destruct
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * Set request url
     * @param  string $urlResource
     * @return void
     */
    private function setRequestUrl(string $urlResource)
    {
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_URL, $urlResource);
        curl_setopt($this->curl, CURLOPT_REFERER, $urlResource);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $this->curl,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.125 Safari/533.4"
        );

        return $this;
    }

    /**
     * Execute
     * @return string|null
     * @throws NotFoundException
     * @throws TransportException
     */
    private function execute()
    {
        $result = curl_exec($this->curl);
        $code = (int) curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        if ($code > 299) {
            $lastUrl = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
            $errorMessage = sprintf(
                "Unexpected HTTP response (%d) from resource %s",
                $code,
                $lastUrl
            );

            if (in_array($code, [400, 404])) {
                throw new NotFoundException($errorMessage);
            } else {
                throw new TransportException($errorMessage);
            }
        }

        if ($result === "") {
            return null;
        }

        return $result;
    }

    /**
     * Get resource page
     * @param  string $urlResource
     * @return void
     */
    public function get(string $urlResource)
    {
        return $this->setRequestUrl($urlResource)->execute();
    }
}
