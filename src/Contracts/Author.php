<?php

namespace BinaryCats\Laranote\Contracts;

interface Author
{
    /**
     * Check if a comment for a specific model needs to be approved.
     *
     * @param  mixed $model
     * @return bool
     */
    public function needsNoteApproval($model): bool;
}
