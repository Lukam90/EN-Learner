## Ex Tri

```php
function display($array) {
    foreach ($array as $element) {
        echo "$element ";
    }

    echo "\n";
}

function swap(&$a, &$b) {
    $temp = $a;
    $a = $b;
    $b = $temp;
}

function customCount($array) {
    $length = 0;

    foreach ($array as $element) {
        $length++;
    }

    return $length;
}

function customSort(&$array) {
    // Longueur du tableau

    $length = customCount($array);

    if ($length <= 1) {
        return $array;
    }

    // Parcours du tableau

    for($i = $length - 1 ; $i >= 1 ; $i--) {
        for($j = 0 ; $j <= ($i - 1) ; $j++) {
            if ($array[$j + 1] < $array[$j]) {
                swap($array[$j + 1], $array[$j]);
            }
        }
    }
}

function testSort($array) {
    customSort($array);
    display($array);
}

testSort([0, 12, 800, 30, 300, 15, 9, 2, 89, 40]);
```