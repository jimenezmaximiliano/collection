#Collection

A simple collection package compatible with PHP 5.4 with no dependencies

## Usage

### Example

```php
$collection = new Collection(['apple', 'orange', 'peach']);


$collection->map(function ($fruit) {
    return 'Don\'t touch my fucking ' . $fruit;
})->each(function($rule) {
    echo $rule . '<br />';
});
```

### Creating

$collection = new Collection;
$collection2 = new Collection([1, 2, 3]);
$collection3 = new Collection([
    'hello' => 'goodbye',
    'your mother' => 'should know',
]);

### Adding items

#### push

```php
$collection = new Collection;
$collection->push('item');
$collection->push('item2');

$collection->toArray(); // ['item', 'item2'];
```

#### put

```php
$collection = new Collection;
$collection->put('key', 'value');

$collection->toArray(); // ['key' => 'value'];
```

### Filtering

#### filter
```php
$collection = new Collection([1, 2, 3, 4]);
$collection->filter(function($value, $key) {
    return $value < 3;
});

$collection->toArray(); // [1, 2];
```

#### reject
```php
$collection = new Collection([1, 2, 3, 4]);
$collection->reject(function($value, $key) {
    return $value < 3;
});

$collection->toArray(); // [3, 4];
```

### Snooping

#### hasKey
```php
$collection = new Collection(['propietario' => 1]);

$collection->hasKey('propietario'); // true
$collection->hasKey('un chorro'); // false;
```

#### hasValue
```php
$collection = new Collection(['propietario' => 1]);

$collection->hasValue(1); // true
$collection->hasValue(2); // false;
```

#### count

Self explanatory

#### isEmpty

Self explanatory

#### isNotEmpty

Self explanatory



### Getting items

#### all

Self explanatory

#### toArray

Self explanatory

#### first

Self explanatory

#### get

```php
$collection = new Collection(['key' => 'value']);

$collection->get('key'); // 'value'
```

#### keys

```php
$collection = new Collection(['key' => 'value', 'key2' => 'value2']);

$collection->keys()->toArray(); // ['key', 'key2'] 
```

#### values

```php
$collection = new Collection(['key' => 'value', 'key2' => 'value2']);

$collection->keys()->toArray(); // ['value', 'value2'] 
```

#### reduce

```php
$collection = new Collection([1, 1, 1]);

$collection->reduce(function ($value, $initial) {
    return $initial + $value;
}, 0); // 3
```

#### implode

```php
$collection = new Collection([1, 2, 3]);

$collection->implode('.'); // '1.2.3'
```

### Iterating

#### each
```php
$collection = new Collection([1, 2, 3]);

$collection->each(function ($value, $key) {
    // do something
});
```

#### map
```php
$collection = new Collection([1, 2, 3]);

$collection->map(function ($value, $key) {
    return $value * 2;
});

$collection->toArray(); // [2, 4, 6]
```

### Moring

#### merge
```php
$collection = new Collection([1, 2, 3]);

$collection->merge([4]);

$collection->toArray(); // [1, 2, 3, 4]
```
