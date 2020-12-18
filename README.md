## Laravel Xero

A simple Laravel package to work with XERO API. Using latest OAuth 2.0.

### Getting Started
1. Register and create new application in XERO, https://developer.xero.com.
2. Get Client ID and Client Secret key and key in the redirect URI.


### Installation

Install the package using composer:

```bash
composer require supplycart/xero
```

Add this to your `.env` file:

```env
XERO_CLIENT_ID={your client id}
XERO_CLIENT_SECRET={your client secret}
XERO_REDIRECT_URI={your oauth redirect uri}
XERO_AUTHENTICATED_URI={your redirected url after oauth}
```
