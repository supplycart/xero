<?php

namespace Supplycart\Xero\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Supplycart\Xero\Data\TokenResponse;

class XeroAuthenticated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \Supplycart\Xero\Data\TokenResponse
     */
    public $response;
    /**
     * @var string
     */
    public $state;

    /**
     * Create a new event instance.
     */
    public function __construct(TokenResponse $response, string $state)
    {
        $this->response = $response;
        $this->state = $state;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('xero@' . $this->state);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['response' => $this->response->toArray()];
    }
}
