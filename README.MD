# PHP CURL OOP library
#### Download
```sh
php composer.phar require sunnyct/curl
```
#### Use
```php
use SunNYCT\CURL\Request;

$request = new Request('http://example.com');
$request->setOption(CURLOPT_CUSTOMREQUEST, 'POST');

$response = $request->execute();
echo $response->getCode();
```