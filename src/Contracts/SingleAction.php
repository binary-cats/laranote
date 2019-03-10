<?php

namespace BinaryCats\Laranote\Contracts;

interface SingleAction
{
    /**
     * Return the value of the field to which the comparison needs to be made
     *
     * @param  array
     * @return mixed
     */
    public function execute(array $data);
}
