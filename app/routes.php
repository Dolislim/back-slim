<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    // Users / thirdparties
    // Todo: Création utilisateur + client
    // Todo: Vérification si existe déjà (email)
    // Todo: Connexion avec récupération token
    // Todo: Affichage d'un client (id)
    // Todo: Modification informations personnelles (id)
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    // Proposals
    // Todo: Création d'un devis
    // Todo: Liste des devis
    // Todo: Affichage d'un devis
    $app->group('/proposals', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });

    // Orders
    // Todo: Liste des commandes
    // Todo: Affichage d'une commande
    // Todo: Faire un paiement
    $app->group('/orders', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });

    // Invoices
    // Todo: Liste des factures
    // Todo: Affichage d'une facture
    $app->group('/invoices', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });

    // Shipments
    // Todo: Liste des expéditions
    // Todo: Informations sur une expédition
    $app->group('/shipments', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });

    // Documents
    // Todo: Liste des document d'une partie
    // Todo: Affichage d'un document (download)
    $app->group('/documents', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });

    // Products
    // Todo: Liste des produits
    // Todo: Affichage d'un produit
    $app->group('/products', function (Group $group) {
        $group->get('', ListUsersAction::class);
    });
};
