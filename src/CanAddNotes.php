<?php

namespace BinaryCats\Laranote;

use Illuminate\Database\Eloquent\Model;

trait CanAddNotes
{
    /**
     * Check if a comment for a specific model needs to be approved.
     *
     * @param mixed $model
     * @return bool
     */
    public function needsNoteApproval($model): bool
    {
        return true;
    }
}
