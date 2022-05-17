<?php

declare(strict_types=1);

namespace App\Application\Actions\Products;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * GET list of products in a category
 * GET liste des produits d'une catégorie
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 * @example get('/category/{id}', Products\ListProductsByCategoryAction::class)
 * @uses int id, Category ID to retrieve
 */
final class ListProductsByCategoryAction extends ProductsAction
{
    protected function action(): Response
    {
        $categoryId = (int) $this->resolveArg('id');

        $this->apiResponse = $this->apiProducts->getAllProducts(['limit' => 0, 'category' => $categoryId]);

        return $this->respondWithData($this->apiResponse);
    }
}
