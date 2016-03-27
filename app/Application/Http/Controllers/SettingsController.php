<?php
namespace JWTPOC\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use JWTPOC\Resources\Settings\Application\Http\Controller;
use JWTPOC\Resources\Settings\Presentation\Models\Item;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SettingsController extends BaseController
{
    /** @var Controller  */
    protected $controller;

    /**
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->getRouter()->model('settings', Item::class);
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

    /**
     * @todo improve this. allow wildcards
     *
     * @param $name
     * @param $attribute
     * @return JsonResponse
     */
    public function getItemAttribute($name, $attribute)
    {
        $itemFlat = $this->show($name);

        if (array_key_exists($attribute, $itemFlat)) {
            return $itemFlat[$attribute];
        }

        return new JsonResponse([], 404);
    }
}
