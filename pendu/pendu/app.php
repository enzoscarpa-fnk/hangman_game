<?php
function getWordsDictionnary()
{
    $pathFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'dictionnaire.json';
    $fileContent = file_get_contents($pathFile);
    $data = json_decode($fileContent, true);
    return $data;
}

function playerChooseCat($data)
{
    $cat = readline("Veuillez choisir une categorie:\n1 = Nourriture\n2 = Animaux\n3 = Professions\n4 = Sciences\n");
    switch ($cat) {
        case '1':
            echo "Catégorie 'Nourriture' choisie.\n";
            $catArray = $data["nourriture"];
            break;
        case '2':
            echo "Catégorie 'Animaux' choisie.\n";
            $catArray = $data["animaux"];
            break;
        case '3':
            echo "Catégorie 'Professions' choisie.\n";
            $catArray = $data["professions"];
            break;
        case '4':
            echo "Catégorie 'Sciences' choisie.\n";
            $catArray = $data["sciences"];
            break;
        default:
            echo "Catégorie aléatoire choisie par l'ordinateur.\n";
            $randomCat = array_rand($data);
            $catArray = $data[$randomCat];
            break;
    }
    return $catArray;
}

function computerChooseWord($catArray)
{
    $randomNb = array_rand($catArray);
    $word = $catArray[$randomNb];
    return $word;
}

function game($word)
{
    $hp = 5;
    $lettersPlayed = [];
    $wordplay = [];
    for ($i = 0; $i < strlen($word); $i++) {
        $wordplay[] = '_';
    }
    echo implode('', $wordplay) . PHP_EOL . PHP_EOL;
    while (implode('', $wordplay) != $word && $hp >= 1)
    {
        echo "Lettres déjà jouées: " . implode(', ', $lettersPlayed) . PHP_EOL;
        $letter = strtolower(readline("Veuillez entrer une lettre: " . PHP_EOL));
        if (in_array($letter, $lettersPlayed)) {
            echo "\033[0;31mVous avez déjà essayé la lettre '$letter'. Veuillez en choisir une autre.\033[0m" . PHP_EOL;
            continue;
        }
        $lettersPlayed[] = $letter;
        $i = 0;
        $found = false;
        while (($pos = strpos($word, $letter, $i)) !== false) {
            $wordplay[$pos] = $letter;
            $i = $pos + 1;
            $found = true;
        }
        if (!$found)
        {
            $hp--;
            echo "\033[0;31mIl vous reste $hp essais.\033[0m" . PHP_EOL . PHP_EOL;
        }
        echo implode('', $wordplay) . PHP_EOL . PHP_EOL;
    }
    if ($hp <= 0)
    {
        echo "\033[0;31mVous avez épuisé tous vos essais. Le mot à trouver était: $word.\033[0m" . PHP_EOL;
    }
    else
    {
        echo "\033[0;32mFélicitation ! Vous avez trouvé le mot $word !\033[0m" . PHP_EOL;
    }
}
?>