<?php
namespace JWTPOC\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use JWTPOC\Resources\Clients\Application\Http\Controller;
use JWTPOC\Resources\Clients\Presentation\Models\Item;

class ClientsController extends BaseController
{
    /** @var Controller  */
    protected $controller;

    /**
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        return $this->controller->getListing()->toArray();
    }

    public function show($name)
    {
        try {
            $item = $this->controller->getItem($name);

            if ($item instanceof Item) {
                return $item->toArray();
            }

        } catch (\Exception $e) {
            return new JsonResponse([], 404);
        }
    }
}
