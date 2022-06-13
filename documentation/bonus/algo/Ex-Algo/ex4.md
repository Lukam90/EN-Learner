## Ex 4

```php
function isEven($number) {
    $result = "paire";

    if ($number % 2 != 0)   $result = "im" . $result;

    echo "La valeur $number est $result.\n";
}

isEven(2);
isEven(3);
```