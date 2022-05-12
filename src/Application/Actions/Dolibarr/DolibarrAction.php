<?php

declare(strict_types=1);

namespace App\Application\Actions\Dolibarr;

use Psr\Http\Message\ResponseInterface as Response;

use App\Application\Actions\Action;
use App\Domain\Dolibarr\Products;

// 'final' bloque et permet de ne pas étendre cette class
final class DolibarrAction extends Action
{
    protected $products;
    protected $test;

    public function __construct()
    {
        $this->products = new Products;
        $this->test = $this->products->test("Thomas");
    }

    protected function action(): Response
    {
        return $this->respondWithData($this->test);
    }
}
