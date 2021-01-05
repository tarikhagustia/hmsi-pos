<?php

namespace App\Events;

use App\StockDemand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockDemandCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var StockDemand
     */
    public $stockDemand;

    /**
     * Create a new event instance.
     *
     * @param StockDemand $stockDemand
     */
    public function __construct(StockDemand $stockDemand)
    {
        //
        $this->stockDemand = $stockDemand;
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
