# Installing
Create `docker/database.env` and `.env` from examples

Use command `docker compose up --build`

or `docker-compose up --build`

# Using
Connect to the app container with command `docker exec -it {container name} bash`

Execute command you want. Command Examples:
## Crypto Analytics
`php artisan app:crypto-analytics binance BTC USDT`
example out
```
Max price = 71879.9 from jbex platform
Min price = 71744.3 from bybit platform
```

## Crypto Profit Analytics
`php artisan app:crypto-profit-analytics binance poloniex`

example out
```
Buying in binance -> selling in poloniex
For pair "ETHBTC" profit=0.079978672354026 %
For pair "LTCBTC" profit=0.099900099900113 %
For pair "NEOBTC" profit=1.9148936170213 %
For pair "EOSETH" profit=6.7409144196952 %
For pair "GASBTC" profit=-0.17921146953405 %
For pair "BTCUSDT" profit=-0.018364582811204 %
For pair "ETHUSDT" profit=-0.022087163308818 %
For pair "LRCBTC" profit=-7.4285714285714 %
For pair "QTUMBTC" profit=2.0776874435411 %
```
