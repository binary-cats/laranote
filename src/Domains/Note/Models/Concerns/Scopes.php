<?php

namespace BinaryCats\Laranote\Domains\Note\Models\Concerns;

use BinaryCats\Laranote\Exceptions\NoteException;

trait Scopes
{
    /**
     * Scope only Public records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->whereIsPrivate(false);
    }

    /**
     * Scope only Private records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate($query)
    {
        return $query->whereIsPrivate(true);
    }

    /**
     * Scope notes by encrypted Context Key
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsingContextKey($query, $encryptedString)
    {
        return $query->where(function ($advanced) use ($encryptedString) {
            $morph = $this->decryptContextKey($encryptedString);

            return $advanced->whereContextType($morph['model'])
                            ->whereContextId($morph['id']);
        });
    }

    /**
     * Decrypt the context key
     *
     * @param  string $encryptedString
     * @return array
     */
    protected function decryptContextKey($encryptedString)
    {
        try {
            $context = decrypt($encryptedString);
        } catch (\Exception $e) {
            throw new NoteException($e->getMessage(), $e->getCode());
        }

        return $context;
    }
}
