# Extra Fee GraphQL

**Extra Fee GraphQL is a part of MageINIC Extra Fee extension that adds GraphQL features.** This extension extends Extra Fee definitions.

## 1. How to install

Run the following command in Magento 2 root folder:

```
composer require mageinic/extra-fee-graphql

php bin/magento maintenance:enable
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento maintenance:disable
php bin/magento cache:flush
```

**Note:**
Magento 2 Extra Fee GraphQL requires installing [MageINIC Extra Fee](https://github.com/mageinic/Extra-Fee) in your Magento installation.

**Or Install via composer [Recommend]**
```
composer require mageinic/extra-fee
```

## 2. How to use

- To view the queries that the **MageINIC Extra Fee GraphQL** extension supports, you can check `Extra Fee GraphQl User Guide.pdf` Or run `ExtraFeeGraphql.json` in Postman.

## 3. Get Support

- Feel free to [contact us](https://www.mageinic.com/contact.html) if you have any further questions.
- Like this project, Give us a **Star**
