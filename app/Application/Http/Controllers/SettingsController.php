<?php
namespace JWTPOC\Application\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use JWTPOC\Resources\Settings\Application\Http\Controller;

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
    }

    public function getListing()
    {
        return $this->controller->getListing()->toArray();
    }
}
