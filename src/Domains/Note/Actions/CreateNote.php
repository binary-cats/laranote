<?php

namespace BinaryCats\Laranote\Domains\Note\Actions;

use BinaryCats\Laranote\Events\NoteCreating;
use BinaryCats\Laranote\Events\NoteCreated;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class CreateNote extends Action
{
    /**
     * Bind the implementation of the Noteable model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create new action to make a mote
     *
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new instance of self
     *
     * @param   Illuminate\Database\Eloquent\Model$model
     * @return  new static
     */
    public static function make(Model $model)
    {
        return new static($model);
    }

    /**
     * Validate the note and then create a new note
     *
     * @param  array  $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function execute($data = [])
    {
        # validate the data
        $record = $this->validate($data);
        # Make a new record
        $note = $this->model
                    ->notes()
                    ->make($record)
                    ->author()
                    ->associate($this->author($data));
        # Emit events
        event(new NoteCreating($note));
        # Save the note
        $note->save();
        # Emit events
        event(new NoteCreated($note));
        # return
        return $note;
    }

    /**
     * Get the values and valie the input
     *
     * @param  array $data
     * @return array
     */
    protected function validate($data)
    {
        $note = Arr::only($data, [
            'content',
            'is_private',
            'user_id',
        ]);

        return $note;
    }

    /**
     * Resolve User from the attributes
     *
     * @param  array $data
     * @return Model|null
     */
    protected function author($data)
    {
        return Arr::get($data, 'user');
    }
}
