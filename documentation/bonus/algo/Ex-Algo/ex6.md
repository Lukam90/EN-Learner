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