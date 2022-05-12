<?php

declare(strict_types=1);

// On utilise le même espace de travail
namespace App\Application\Actions\Exemple;

// On importe l'interface de réponse
use Psr\Http\Message\ResponseInterface as Response;

// 'final' bloque et permet de ne pas étendre cette class
final class ExempleWithParentAction extends ExempleAction
{
    // On crée une action qui sera appelée par la route, ex:
    // use App\Application\Actions\Exemple\ExempleWithParentAction;
    // $app->get('', ExempleWithParentAction::class);
    protected function action(): Response
    {
        /**
         * Du code selon nos besoins
         */
        $this->test['ExempleWithParentAction'] = "Action finale OK";

        // On retourne la réponse de l'action, ici le test dispo dans la class parent
        return $this->respondWithData($this->test);
    }
}
