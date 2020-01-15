<?php

namespace Supplycart\Xero\Actions;

class Authenticate extends Action
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle()
    {
        $query = http_build_query([
            'scope' => config('xero.oauth2.scope'),
            'state' => request()->get('state'),
            'response_type' => 'code',
            'approval_prompt' => 'auto',
            'redirect_uri' => url(config('xero.oauth2.redirect_path')),
            'client_id' => config('xero.oauth2.client_id'),
        ]);

        return redirect()->away(config('xero.oauth2.authorize_url') . '?' . $query);
    }
}
