<?php

namespace BinaryCats\Laranote\Events;

use BinaryCats\Laranote\Contracts\Note;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

abstract class Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Bind the implementation
     *
     * @var BinaryCats\Laranote\Contracts\Note
     */
    protected $note;

    /**
     * Create new event
     *
     * @param BinaryCats\Laranote\Contracts\Note $note
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
