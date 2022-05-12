<?php

declare(strict_types=1);

namespace App\Domain\Dolibarr;

use App\Domain\Dolibarr\Dolibarr;
use App\Domain\Dolibarr\Documents;

/**
 * Product management with Dolibarr API
 * @author Thomas Savournin <tosave.vbl@gmail.com>
 */
final class Products extends Dolibarr
{
    /**
     * GET a list of products
     * "products?sortfield=t.ref&sortorder=ASC&limit=100&page=0&mode=1&category=0"
     * @param int $limit Limit for list
     * @param int $page Page number
     */
    public function getAllProducts($category = 1, $limit = 100, $page = 0)
    {
        $sortfield = 't.ref'; // Sort field
        $sortorder = 'ASC'; // Sort order
        $mode = 1; // 0 for all, 1 for only product, 2 for only service

        $data = $this->getDolibarr('products?sortfield=' . $sortfield . '&sortorder=' . $sortorder . '&limit=' . $limit . '&page=' . $page . '&category=' . $category); // On récupère la liste des produits

        // Todo: Utiliser les collections de laravel
        if (!isset($data['error'])) {
            foreach ($data as $key => $value) // Pour chaque produit on ajoute une image
            {
                $documments = new Documents;
                $image = $documments->getDocumentsById($value['id']);
                if (isset($image['images'])) // Si une image est trouvée
                {
                    $data[$key]['image'] = $image['images'][0];
                }
            }
        }

        return $this->collectDolibarr($data);
    }

    public function getProductById()
    {
    }

    public function getProductByRef()
    {
    }

    public function getProductCategoriesById()
    {
    }

    public function verifProductByIdRef()
    {
    }

    public function test($name = null)
    {
        return [
            'Products' => 'Retour du Domain OK',
            'Name' => $name
        ];
    }
}
