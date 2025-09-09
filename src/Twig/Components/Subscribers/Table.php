<?php

namespace App\Twig\Components\Subscribers;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[AsTwigComponent]
final class Table
{
    public Paginator $subscribers;
}
