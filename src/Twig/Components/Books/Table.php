<?php

namespace App\Twig\Components\Books;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Table
{

    public array $books = [];

}
