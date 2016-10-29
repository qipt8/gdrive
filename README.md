# gdrive
### Installation
To install, simply:

    $ composer require marxvn/gdrive

### Quick Start and Examples

More examples are available under [/examples](https://github.com/marxvn/gdrive/tree/master/examples).

```php
require __DIR__ . '/vendor/autoload.php';
use \Marxvn\gdrive;
$gdrive = new gdrive;
$gdrive->getLink('LINK_GOOGLE_DRIVE');
$json_videojs_source = $gdrive->getSources();
$json_jwplayer_souce = $gdrive->getSources('jwplayer');
```

### Available Methods
```php
gdrive::sources
gdrive::setItag(array $itag)
gdrive::setVidcode(array $vidcode)
gdrive::setTitle($title)
gdrive::getLink($gurl)
gdrive::getSources($type = 'videojs')
```

