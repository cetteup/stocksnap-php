# stocksnap-php
Unofficial PHP HTTP client to access Stocksnap's API

## Installation

`Stocksnap-PHP` uses [Composer](https://getcomposer.org/). To use it, require the library

```
composer require diza/stocksnap
```

## Usage

### API methods

#### Diza\Stocksnap\HttpClient->all_photos($order_by, $sort_order, $page)
Retrieve a list of photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required | Note  |
---------------|------|--------------|-------|
`$order_by`    | string  | Opt *(Default: date)* | Accepted values: `date`, `trending`, `views`, `downloads`, `favorites`
`$sort_order`  | string  | Opt *(Default: desc)*    | Accepted values: `asc`, `desc`
`$page`    | int  | Opt *(Default: 1)*

**Example**

```php
$stocksnap = new Diza\Stocksnap\HttpClient();
$photos = $stocksnap->all_photos($order_by, $sort_order, $page);
```

===

#### Diza\Stocksnap\HttpClient->author_photos($author_id, $page)
Retrieve author's/user's photos.

*Note:* You need to instantiate an httpclient object first

**Arguments**

  Argument     | Type | Opt/Required
---------------|------|--------------
`$author_id`    | int  | Required
`$page`    | int  | Opt *(Default: 1)*

**Example**

```php
$stocksnap = new Diza\Stocksnap\HttpClient();
$photos = $stocksnap->author_photos($author_id, $page);
```
