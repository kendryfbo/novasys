<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Comercial\FacturaNacional;

class CreateFacturaNacionalEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $facturaNacional;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FacturaNacional $facturaNacional)
    {
        $this->facturaNacional = $facturaNacional;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
