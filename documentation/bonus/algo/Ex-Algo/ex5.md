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