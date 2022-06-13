## Ex 7

```php
function countB($string) {
    $res = 0;

    $length = strlen($string);

    for ($index = 0; $index < $length ; $index++) {
        $letter = $string[$index];

        if ($letter === "B") {
            $res++;
        }
    }

    return $res;
}

$string = "BoB mange un BaoBaB.";

$nb = countB($string);

echo "Il y a $nb 'B' dans la chaîne '$string'\n";

function countChar($string, $char) {
    $res = 0;

    $length = strlen($string);

    for ($index = 0; $index < $length ; $index++) {
        $letter = $string[$index];

        if ($letter === $char) {
            $res++;
        }
    }

    return $res;
}

$string = "Bob mange une pizza.";
$char = "a";

$nb = countChar($string, $char);

echo "Il y a $nb '$char' dans la chaîne '$string'\n";
```