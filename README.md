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

var_dump($response instanceof Article);

// multiple data
$collect = new Collection();

$article2 = new Article('The Title Of Article 2.', 'The Body.');
$article2->setLicense($license);

$collect->push($article)->push($article2);

$response = $client->post($collect);

var_dump($response instanceof Colletion);

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


// multiple data
$collect = new Collection();

$article2 = new Article('The Title Of Article 2.', 'The Body.');
$article2->setLicense($license)
    ->setAuthor($author);

$collect->push($article)->push($article2);

$response = $client->post($collect);


```

## License Instance

```
$license = License::fromJson($json);
```

## Exception

```
try {
$response = $client->post($collect);
} catch (\Exception $e) {
    echo $e->getMessage();
}
```
