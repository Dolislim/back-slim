<?php

declare(strict_types=1);

namespace App\Application\Actions\Products;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * GET product information by ID
 * GET les informations d'un produit par ID
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 * @example get('/{id}', Products\GetProductByIdAction::class)
 * @uses int id, Product ID to retrieve
 */
final class GetProductByIdAction extends ProductsAction
{
    protected function action(): Response
    {
        $productId = (int) $this->resolveArg('id');

        $this->apiResponse = $this->apiProducts->getProductById($productId);

        return $this->respondWithData($this->apiResponse);
    }
}
