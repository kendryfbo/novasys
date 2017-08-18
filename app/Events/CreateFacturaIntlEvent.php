<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Models\Comercial\FacturaIntl;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateFacturaIntlEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $factura;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FacturaIntl $factura)
    {
        $this->factura = $factura;
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
