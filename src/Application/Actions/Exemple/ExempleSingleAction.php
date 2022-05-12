<?php

declare(strict_types=1);

// On défini l'espace de travail
namespace App\Application\Actions\Exemple;

// On importe l'interface de réponse
use Psr\Http\Message\ResponseInterface as Response;

// On va étendre la class Action
use App\Application\Actions\Action;

// 'final' bloque et permet de ne pas étendre cette class
final class ExempleSingleAction extends Action
{
    // On déclare selon nos besoins
    protected $test;

    // On construit selon nos besoins
    public function __construct()
    {
        $this->test = ['test' => 'Single action OK'];
    }

    // On crée une action qui sera appelée par la route, ex:
    // use App\Application\Actions\Exemple\ExempleSingleAction;
    // $app->get('', ExempleSingleAction::class);
    protected function action(): Response
    {
        /**
         * Du code selon nos besoins
         */

        // On retourne la réponse de l'action
        return $this->respondWithData($this->test);
    }
}
