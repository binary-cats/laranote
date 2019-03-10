<?php

namespace BinaryCats\Laranote\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Noteable
{
    /**
     * Relate Model to notes model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes() : MorphMany;
}
