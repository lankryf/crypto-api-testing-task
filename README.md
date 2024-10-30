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
`php artisan app:crypto-profit-analytics binance jbex`

example out
```
Buying in binance -> selling in jbex
For pair "BTCUSDT" profit=-0.1200000000099
For pair "ETHUSDT" profit=1.3499999999999
For pair "BNBUSDT" profit=-0.099999999999909
For pair "XRPUSDT" profit=-9.9999999999989E-5
For pair "TRXUSDT" profit=1.000000000001E-5
For pair "USDCUSDT" profit=0
For pair "DOGEUSDT" profit=-1.000000000001E-5
For pair "DAIUSDT" profit=-0.0181
For pair "SANDUSDT" profit=0.00029999999999997
For pair "DOTUSDT" profit=1.371
For pair "TRBUSDT" profit=0.009999999999998
For pair "SUSHIUSDT" profit=0
For pair "UNIUSDT" profit=0.0079999999999991
```
