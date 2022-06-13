## Ex 2

```php
$notes = [14, 15.5, 17, 8, 10];

$nb = 0;

$moyenne = 0;

foreach ($notes as $note) {
    $moyenne += $note;
    $nb++;
}

$moyenne /= $nb;

echo "La moyenne des notes est : $moyenne / 20.\n";
```