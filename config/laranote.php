<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Note Models
    |--------------------------------------------------------------------------
    |
    | Register responsible model handlers
    */

   'models' => [
        # Note Model is a standard Eloquent model
        # BinaryCats\Laranote\Contracts\Note interface
        'note' => \BinaryCats\Laranote\Domains\Note\Models\Note::class,

        # Note Model is a standard Eloquent model
        # In the future, we may decide that an author of a note could a non-user
        # like an "Customer"  model commenting on "Order" model
        'author' => \App\User::class,
    ],

   /*
    |--------------------------------------------------------------------------
    | Binary Cats | Note Resources
    |--------------------------------------------------------------------------
    |
    | Exposed within built-in http service, those are the transformation classes
    */

   'resources' => [
        'note'    => \BinaryCats\Laranote\Http\Resources\NoteResource::class,
        'author'  => \BinaryCats\Laranote\Http\Resources\AuthorResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Binary Cats | Add API endpoint
    |--------------------------------------------------------------------------
    |
    | Expose an API end point
    */
   'routing' => [
        'enabled' => true,
   ]
];
