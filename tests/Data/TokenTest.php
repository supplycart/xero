<?php

namespace Supplycart\Xero\Tests\Data;

use Illuminate\Support\Facades\File;
use Supplycart\Xero\Data\Token;
use Supplycart\Xero\Tests\TestCase;

class TokenTest extends TestCase
{
    public function test_can_initialize_token()
    {
        $data = (array) json_decode(File::get(__DIR__.'/../stubs/xero/access-token.json'));

        $token = new Token($data);

        $this->assertNotNull($token->accessToken);
        $this->assertNotNull($token->idToken);
        $this->assertNotNull($token->refreshToken);
        $this->assertNotNull($token->tokenType);
        $this->assertNotNull($token->expiresIn);
    }
}