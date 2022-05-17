<?php

declare(strict_types=1);

namespace App\Application\Actions\Products;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

use App\Domain\Dolibarr\Products;

/**
 * initialization of actions for managing and displaying products
 * initialisation des actions pour la gestion et l'affichage des produits
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 */
abstract class ProductsAction extends Action
{
    protected Products $apiProducts;
    protected $apiResponse;

    public function __construct(LoggerInterface $logger, Products $products)
    {
        parent::__construct($logger);
        $this->apiProducts = $products;
    }
}
