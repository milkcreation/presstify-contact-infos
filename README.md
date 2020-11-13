# Contact Infos PresstiFy Plugin

[![Latest Version](https://img.shields.io/badge/release-2.0.3-blue?style=for-the-badge)](https://svn.tigreblanc.fr/presstify-plugins/theme-suite/tags/2.0.0)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

## Installation

```bash
composer require presstify-plugins/contact-infos
```

## Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \tiFy\Plugins\ContactInfos\ContactInfosServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/contact-infos.php
// @see /vendor/presstify-plugins/contact-infos/config/contact-infos.php
return [
      //...

      // ...
];
```