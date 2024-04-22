<?php

namespace App\Events;

use App\Models\Products;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyStoreRowsReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rows;
    public $class;

    /**
     * Create a new event instance.
     * @param array $rows
     * @param string $class
     */
    public function __construct(array $rows, string $class)
    {
        $this->rows = $rows;
        $this->class = $class;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
