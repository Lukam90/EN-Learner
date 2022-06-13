## Ex 9

```php
// L'algorithme affiche une liste de nombres dans un ordre décroissant

$tableau = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$i = count($tableau) - 1;

while ($i >= 0) {
    echo $tableau[$i] . "<br />";
    $i--;
}

// Affichage des nombres pairs dans l'ordre croissant

$i = 0;

echo "\n";

while ($i <= count($tableau) - 1) {
    $nombre = $tableau[$i];

    if ($nombre % 2 == 0)   echo $tableau[$i] . " ";

    $i++;
}

echo "\n";
```