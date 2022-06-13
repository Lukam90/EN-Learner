## Ex 1

```php
function diceArray() {
    $numbers = [1, 2, 3, 4, 5, 6];

    shuffle($numbers);

    $number = $numbers[0];

    $res = "perdu";

    if ($number == 6)   $res = "gagné";

    echo "diceArray : $number = $res\n";
}

function diceRandom() {
    $number = mt_rand(1, 6);

    $res = "perdu";

    if ($number == 6)   $res = "gagné";

    echo "diceRandom : $number = $res\n";
}

diceArray();
diceRandom();
```