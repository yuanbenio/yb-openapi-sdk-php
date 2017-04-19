# Yuanben/yb-openapi-sdk-php

## Usage

### Media

```
$config = new Config($token, Config::USER_MEDIA);

$client = new Client($config);

$title = 'Hello World.';
$content = 'DearMadMan.';
$article = new Article($title, $content);

$license = new License(License::LICENSE_CC);
$license->setAdaptation(License::LICENSE_CC_ADAPTATION_Y)->setCommercial(License::LICENSE_CC_COMMERCIAL_N);

$article->setLicense($license);

$response = $client->post($article);

$status = $response->getStatusCode();
// 200: ok , 422: missing key of the data, 500: server error.

$body = $response->getBody()->getContents();

// multiple data
$collect = new Collection();

$article2 = new Article('The Title Of Article 2.', 'The Body.');
$article2->setLicense($license);

$collect->push($article)->push($article2);

$response = $client->post($collect);

$body = $response->getBody()->getContents();

```

### Platform

```
$config = new Config($token, Config::USER_PLATFORM);

$client = new Client($config);

$title = 'Hello World.';
$content = 'DearMadMan.';
$article = new Article($title, $content);

$license = new License(License::LICENSE_CC);
$license->setAdaptation(License::LICENSE_CC_ADAPTATION_Y)->setCommercial(License::LICENSE_CC_COMMERCIAL_N);

$author = new Author('i@dearmadman.com', 'DearMadMan.');

$article->setLicense($license)
    ->setAuthor($author);

$response = $client->post($article);

$status = $response->getStatusCode();
// 200: ok , 422: missing key of the data, 500: server error.

$body = $response->getBody()->getContents();

// multiple data
$collect = new Collection();

$article2 = new Article('The Title Of Article 2.', 'The Body.');
$article2->setLicense($license)
    ->setAuthor($author);

$collect->push($article)->push($article2);

$response = $client->post($collect);

$body = $response->getBody()->getContents();

```

## License Instance

```
$license = License::fromJson($json);
```

## Exception

```
$response = $client->post($collect);

$status = $response->getStatusCode();

switch ($status) {
    case 200:
        $responseData = $response->getBody()->getContents();
        break;
    case 422:
        $errorMessage = $response->getBody()->getContents();
        break;
    case 401:
        $errorMessage = $response->getBody()->getContents();
        break;
    default:
        break;
}
```
