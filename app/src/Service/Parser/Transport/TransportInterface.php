<?php

namespace App\Service\Parser\Transport;

/**
 * Interface TransportInterface
 * @package App\Service\Parser\Transport
 */
interface TransportInterface
{
    /**
     * TransportInterface constructor
     */
    public function __construct();

    /**
     * TransportInterface destruct
     */
    public function __destruct();

    /**
     * Get resource page
     * @param  string $urlResource
     * @return string|null
     * @throws TransportException
     * @throws NotFoundException
     */
    public function get(string $urlResource): ?string;
}
