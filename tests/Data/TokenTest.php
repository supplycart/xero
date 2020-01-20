<?php

namespace Supplycart\Xero\Tests\Data;

use Illuminate\Support\Facades\File;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;

class TokenTest extends TestCase
{
    public function test_can_transfer_token_data()
    {
        $data = (array) json_decode(File::get(__DIR__.'/../stubs/xero/access-token.json'));

        $token = new Token($data);

        $this->assertNotNull($token->access_token);
        $this->assertNotNull($token->id_token);
        $this->assertNotNull($token->refresh_token);
        $this->assertNotNull($token->token_type);
        $this->assertNotNull($token->expires_in);
    }
}