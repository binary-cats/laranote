<?php

namespace BinaryCats\Laranote\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $authorResource = $this->authorResource();

        return [
            'id' => $this->id,
            'content' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'author' => $this->whenLoaded('author', new $authorResource($this->author)),
            'notes' => $this->whenLoaded('notes', static::collection($this->notes)),
        ];
    }

    /**
     * Get configurable value for the author resource
     *
     * @return string
     */
    protected function authorResource()
    {
        return config('laranote.resources.author');
    }
}
