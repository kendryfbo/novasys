<?php

namespace App\Events;

use App\Models\Comercial\Proforma;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AuthorizedProformaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $proforma;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Proforma $proforma)
    {
        $this->proforma = $proforma;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
