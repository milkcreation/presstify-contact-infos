# Contact Infos PresstiFy Plugin

[![Latest Version](https://img.shields.io/badge/release-2.0.5-blue?style=for-the-badge)](https://svn.tigreblanc.fr/presstify-plugins/contact-infos/tags/2.0.5)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

**Contact Infos** makes it easy to store and view contact information.

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
// @see /vendor/presstify-plugins/contact-infos/resources/config/contact-infos.php
return [
      //...

      // ...
];
```
