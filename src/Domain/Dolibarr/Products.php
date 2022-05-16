<?php

declare(strict_types=1);

namespace App\Domain\Dolibarr;

use App\Domain\Dolibarr\Dolibarr;

/**
 * Product management with Dolibarr API
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 */
final class Products extends Dolibarr
{
    /**
     * GET a list of products
     * GET une liste de produits
     * @param array $params ['sortfield', 'sortorder', 'limit', 'page', 'mode', 'category', 'sqlfilters', 'ids_only', 'variant_filter', 'pagination_data']
     * @example "products?sortfield=t.ref&sortorder=ASC&limit=100&page=1"
     * @uses string sortfield => 't.ref', Sort field
     * @uses string sortorder => 'ASC', Sort order
     * @uses int limit => 100, Limit for list
     * @uses int page Page => 0, number
     * @uses int mode, Use this param to filter list (0 for all, 1 for only product, 2 for only service)
     * @uses int category, Use this param to filter list by category
     * @uses string sqlfilters, Other criteria to filter answers separated by a comma. Syntax example "(t.tobuy=0) and (t.tosell=1)"
     * @uses bool ids_only, Return only IDs of product instead of all properties (faster, above all if list is long)
     * @uses int variant_filter, Use this param to filter list (0 = all, 1=products without variants, 2=parent of variants, 3=variants only)
     * @uses bool pagination_data, If this parameter is set to true the response will include pagination data. Default value is false. Page starts from 0
     */
    public function getAllProducts($params = [])
    {
        $uri = 'products';

        $default = [
            'sortfield' => 't.ref',
            'sortorder' => 'ASC',
            'limit' => 100,
            'page' => 0
        ];

        $request = $this->createRequestDolibarr($uri, $params, $default);
        return $this->getDolibarr($request);
    }

    /**
     * Return an array with product information
     * Renvoie un tableau avec des informations sur le produit
     * @param int $id ID of product
     * @param array $params ['includestockdata', 'includesubproducts', 'includeparentid', 'includetrans']
     * @example "products/1"
     * @uses int includestockdata, Load also information about stock (slower)
     * @uses bool includesubproducts, Load information about subproducts
     * @uses bool includeparentid, Load also ID of parent product (if product is a variant of a parent product)
     * @uses bool includetrans, Load also the translations of product label and description
     */
    public function getProductById($id, $params = [])
    {
        $uri = 'products/' . $id;

        $request = $this->createRequestDolibarr($uri, $params);
        return $this->getDolibarr($request);
    }

    /**
     * Return an array with product information
     * Renvoie un tableau avec des informations sur le produit
     * @param int $ref Ref of element
     * @param array $params ['includestockdata', 'includesubproducts', 'includeparentid', 'includetrans']
     * @example "products/ref/UNEREF"
     * @uses int includestockdata, Load also information about stock (slower)
     * @uses bool includesubproducts, Load information about subproducts
     * @uses bool includeparentid, Load also ID of parent product (if product is a variant of a parent product)
     * @uses bool includetrans, Load also the translations of product label and description
     */
    public function getProductByRef($ref, $params = [])
    {
        $uri = 'products/ref/' . $ref;

        $request = $this->createRequestDolibarr($uri, $params);
        return $this->getDolibarr($request);
    }

    public function getProductCategoriesById()
    {
    }

    public function verifProductByIdRef()
    {
    }
}
