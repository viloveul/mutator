<p align="center">
<a href="https://travis-ci.com/viloveul/mutator">
<img src="https://travis-ci.com/viloveul/mutator.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/viloveul/mutator">
<img src="https://poser.pugx.org/viloveul/mutator/d/total.svg" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/viloveul/mutator">
<img src="https://poser.pugx.org/viloveul/mutator/v/stable.svg" alt="Latest Stable Version">
</a>
</p>

# Installation

make sure your php version > 7.0

```bash
composer require viloveul/mutator
```

## How

```php
require __DIR__ . '/vendor/autoload.php';

$mutator = new Viloveul\Mutator\Manager();
$mutator->addFilter('test', function(Viloveul\Mutator\Contracts\Context $ctx) {
	$ctx->foo = "baz";
	return $ctx;
});

$payload = new Viloveul\Mutator\Payload([
	'foo' => 'bar'
]);
$result = $mutator->apply('test', $payload);
var_dump($result);
```
