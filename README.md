# OAuth2 Server Bundle for Symfony

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

OAuth2 Server Bundle for Symfony

## Install

Via Composer

``` bash
$ composer require borisguery/oauth2-server-bundle
```

## Configuration

``` yaml
bgy_o_auth2_server:
    authorization_server:
        storage: 
            access_token: oauth2.storage.access_token
            client: oauth2.storage.client
            refresh_token: oauth2.storage.refresh_token
        token_generator: ~
        always_generate_a_refresh_token: true
        always_require_a_client: true
        access_token_ttl: 3600
        refresh_token_ttl: 3600
        grant_types:
            - oauth2.authorization_server.grant_types.password
            - oauth2.authorization_server.grant_types.refresh_token

```

## Usage

``` php
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email guery.b@gmail.com instead of using the issue tracker.

## Credits

- [Boris Guéry][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/borisguery/oauth2-server-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/borisguery/oauth2-server-bundle/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/borisguery/oauth2-server-bundle.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/borisguery/oauth2-server-bundle.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/borisguery/oauth2-server-bundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/borisguery/oauth2-server-bundle
[link-travis]: https://travis-ci.org/borisguery/oauth2-server-bundle
[link-scrutinizer]: https://scrutinizer-ci.com/g/borisguery/oauth2-server-bundle/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/borisguery/oauth2-server-bundle
[link-downloads]: https://packagist.org/packages/borisguery/oauth2-server-bundle
[link-author]: https://github.com/borisguery
[link-contributors]: ../../contributors
