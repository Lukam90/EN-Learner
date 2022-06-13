# Ex - Algorithmes

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

## Ex 5

```php
function createGrid($number) {
    $data = "";

    for ($i = 0 ; $i < $number ; $i++) {
        $data .= "<tr>\n";

        for ($j = 0 ; $j < $number ; $j++) {
            $data .= "<td>X</td>";
        }

        $data .= "\n</tr>";
    }

    $table = 
    "<table>
        <tbody>
            <tr>
                $data
            </tr>
        </tbody>
    </table>\n";

    echo $table;
}

createGrid(5);
```

## Ex 6

```php
function getSeason($month) {
    $season = "";

    switch ($month) {
        case "mars":
        case "avril":
        case "mai":
            $season = "printemps";
            break;
        case "juin":
        case "juillet":
        case "août":
            $season = "été";
            break;
        case "septembre":
        case "octobre":
        case "novembre":
            $season = "automne";
            break;
        case "décembre":
        case "janvier":
        case "février":
            $season = "hiver";
            break;
    }

    return $season;
}

$month = "septembre";
$season = getSeason($month);

echo "La saison du mois $month est : $season\n";
```

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

## Ex 10

```php
class Eleve {
    private $nom;
    private $prenom;
    private $moyenne;

    public function __construct($nom, $prenom, $moyenne) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->moyenne = $moyenne;
    }
}

$eleve1 = new Eleve("René", "DUPONT", 12);
$eleve2 = new Eleve("Nicolas", "DUBOIS", 15);
$eleve3 = new Eleve("Thomas", "DUCHEMIN", 18);
```

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

