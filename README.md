## Installation
1. Create app on https://developer.twitter.com/en/portal/dashboard 
> Use http://127.0.0.1:5173 as Callback URI, use your own domain as Website URI. 
> Access Token and Secret must be with Read and Write permissions.
2. Run mysql server
3. Run `cd backend && cp .env.example .env` and fill the credentials
4. Run `composer install`
5. Run `npm install`

## Run the app
```shell
npm run dev
```

```shell
cd backend && php -S 127.0.0.1:8000
```

```shell
cd cli && php tweet.php
```