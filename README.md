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
Min price = 71944.3 from bybit platform
```

## Crypto Profit Analytics
`php artisan app:crypto-profit-analytics binance BTC USDT`

example out
```
Currencies pair: BTC->USDT
Buying from binance with price 71764.55
Selling in bybit with price 71784.9 => profit 20.349999999991 USDT
Selling in jbex with price 71774.8 => profit 10.25 USDT
Selling in poloniex with price 71778.07 => profit 13.520000000004 USDT
Selling in whitebit with price 71770.38 => profit 5.8300000000017 USDT
```
