<?php

namespace BinaryCats\Laranote;

use BinaryCats\Laranote\Domains\Note\Actions\CreateNote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasManyNotes
{
    /**
     * Return all comments for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes() : MorphMany
    {
        return $this->morphMany(config('laranote.models.note'), 'context');
    }

    /**
     * Attach a note to this model.
     *
     * @param string $content
     * @param boolean $is_private
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function note(string $content, $is_private = false) : Model
    {
        return $this->addNoteAsUser(auth()->user(), $content, $is_private);
    }

    /**
     * Attach a note to this model.
     *
     * @param \Illuminate\Database\Eloquent\Model | null $user
     * @param string $content
     * @param boolean $is_private
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addNoteAsUser(?Model $user, string $content, $is_private = false) : Model
    {
        return CreateNote::make($this)->execute(compact('user', 'content', 'is_private'));
    }

    /**
     * Make context key
     *
     * @return string
     */
    public function makeContextKey()
    {
        return encrypt([
            'model' => $this->getMorphClass(),
            'id' => $this->getKey(),
        ]);
    }
}
