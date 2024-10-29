<?php

namespace NFePHP\Ibpt;

interface RestInterface
{
    /**
     * Pull data form IBPT Restful service to obtain taxes values
     *
     * @param string $uri
     *
     * @return string
     *
     * @throws \Exception
     */
    public function pull($uri);
}
