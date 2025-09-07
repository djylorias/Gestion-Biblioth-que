<?php

namespace App\Twig\Components\Books;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[AsTwigComponent]
final class Table
{

    public Paginator $books;

}
