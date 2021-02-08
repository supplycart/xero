<?php

namespace Supplycart\Xero\Actions;

class AuthenticateInternal extends Action
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle()
    {
        $query = http_build_query([
            'scope' => config('xero.oauth2.scope'),
            'state' => request('state'),
            'response_type' => 'code',
            'approval_prompt' => 'auto',
            'redirect_uri' => config('xero.oauth2_internal.redirect_uri'),
            'client_id' => config('xero.oauth2_internal.client_id'),
        ]);
        
        return redirect()->away(config('xero.oauth2.authorize_url') . '?' . $query);
    }
}