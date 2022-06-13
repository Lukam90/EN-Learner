## Ex 8

```php
function calculerAire($rayon) {
    $aire = M_PI * ($rayon ** 2);
    $aire = round($aire, 2);
    $aire = ceil($aire);

    return $aire;
}

echo calculerAire(5) . "\n";
```