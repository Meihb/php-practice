<?php phpinfo() ?>

<?php

$a = 10;
switch ($a) {
    case $a == 10:
        echo "==10\r\n";
    case $a >= 10:
        echo ">=10\r\n";
}

for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        $inner = "das$i." . $j;
    }
    $out = $inner;
    printf("%s\n", $inner);
}

