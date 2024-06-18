<?php

namespace Supplycart\Xero\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Supplycart\Xero\Data\Token;

class XeroAuthenticated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \Supplycart\Xero\Data\Token
     */
    public $token;
    /**
     * @var string
     */
    public $uuid;

    /**
     * Create a new event instance.
     */
    public function __construct(string $uuid, Token $token)
    {
        $this->uuid = $uuid;
        $this->token = $token;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    #[\Override]
    public function broadcastOn()
    {
        return new PrivateChannel('xero@' . $this->uuid);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['response' => $this->token->toArray()];
    }
}
