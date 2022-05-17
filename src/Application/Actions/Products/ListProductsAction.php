<?php

declare(strict_types=1);

namespace App\Application\Actions\Products;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * GET list of all products
 * GET liste de tous les produits
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 * @example get('', Products\ListProductsAction::class)
 */
final class ListProductsAction extends ProductsAction
{
    protected function action(): Response
    {
        $this->apiResponse = $this->apiProducts->getAllProducts(['limit' => 0]);

        return $this->respondWithData($this->apiResponse);
    }
}
