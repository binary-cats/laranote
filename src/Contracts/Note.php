<?php

namespace BinaryCats\Laranote\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Note
{
    /**
     * Get author model name
     *
     * @return string
     */
    public function getAuthorModelName();
}
