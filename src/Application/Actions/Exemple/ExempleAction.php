<?php

declare(strict_types=1);

// On défini l'espace de travail
namespace App\Application\Actions\Exemple;

// On va étendre la class Action
use App\Application\Actions\Action;

abstract class ExempleAction extends Action
{
    // On déclare selon nos besoins
    protected $test;

    // On construit selon nos besoins
    public function __construct()
    {
        $this->test = ['ExempleAction' => "Initialisation de l'action parent OK"];
    }
}
