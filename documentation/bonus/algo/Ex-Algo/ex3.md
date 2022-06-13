## Ex 3

```php
$numbers = [0, 12, 800, -30, 300, 15, 9, -2, 89, -40];

$length = count($numbers);

$min = $numbers[0];
$max = $numbers[0];

for ($index = 1 ; $index < $length ; $index++) {
    $number = $numbers[$index];

    if ($min < $number) $min = $number;
    if ($max > $number) $max = $number;
}

echo "Le minimum est $min.\n";
echo "Le maximum est $max.\n";
```