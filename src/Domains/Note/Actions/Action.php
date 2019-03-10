<?php

namespace BinaryCats\Laranote\Domains\Note\Actions;

use BinaryCats\Laranote\Contracts\SingleAction;

abstract class Action implements SingleAction
{
    /**
     * Execute the action and return something
     *
     * @param  array
     * @return mixed
     */
    abstract public function execute(array $data);
}
