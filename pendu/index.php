<?php
declare(strict_types=1);

include 'pendu/app.php';

$dictionary = getWordsDictionnary();
$category = playerChooseCat($dictionary);
$word = computerChooseWord($category);
game($word);
?>