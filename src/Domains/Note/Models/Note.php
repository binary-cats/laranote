<?php

namespace BinaryCats\Laranote\Domains\Note\Models;

use BinaryCats\Laranote\HasManyNotes;
use BinaryCats\Laranote\Contracts\Note as NoteModel;
use BinaryCats\Laranote\Exceptions\NoteException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends Model implements NoteModel
{
    use SoftDeletes;
    use Concerns\HasAttributes;
    use Concerns\Scopes;
    use HasManyNotes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'is_private',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'is_private',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_private',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Model belongs to author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo($this->getAuthorModelName(), 'user_id');
    }

    /**
     * Model belongs to context
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function context() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Resolve the author model name
     *
     * @return string
     * @throws BinaryCats\Laranote\Exceptions\NoteException
     */
    public function getAuthorModelName()
    {
        # Default to laranote definition
        if ($model = config('laranote.models.author')) {
            return $model;
        }
        # attempt a sane substitute
        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }
        # finally
        throw new NoteException('Could not locate Note Author model name.');
    }
}
