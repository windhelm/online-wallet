# ONLINE WALLET CONSOLE APPLICATION

LARAVEL 5.2 REST API + WALLET_PHP_CONSOLE

## Installation

### LARAVEL

Run the following to include this via Composer

```shell
composer install
```

### WALLET_PHP_CONSOLE

Run the command in console

```shell
cd ./wallet_console
```

## Available command`s

###example

#### Help

```shell
php wallet.php help
```

#### Login

```shell
php wallet.php login "bakkker@mail.ru" 123456
```

#### Logout

```shell
php wallet.php logout
```

#### Status

Show all wallets user

```shell
php wallet.php status
```

#### Balance

show the balance in the currency translation

```shell
php wallet.php balance 1b1085f0-57c0-11e6-8f97-5375de0d704d USD
```

#### IncreaseAmount

Increase amount

```shell
php wallet.php increaseAmount 1b1085f0-57c0-11e6-8f97-5375de0d704d USD
```

#### DecreaseAmount

Decrease amount

```shell
php wallet.php decreaseAmount 1b1085f0-57c0-11e6-8f97-5375de0d704d USD
```