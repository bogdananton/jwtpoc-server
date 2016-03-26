<?php
namespace JWTPOC\Http;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MultiRouting\Router;
use MultiRouting\Adapters\Main\Adapter as MainAdapter;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Kernel extends Container
{
    /**
     * @var Router
     */
    protected $router;

    public function __construct()
    {
        $this->setRouter();
        $this->initRoutes();
    }

    protected function setRouter()
    {
        $eventsDispatcher = new Dispatcher($this);
        $this->router = new Router($eventsDispatcher, $this);
        $this->router->allowAdapters([
            MainAdapter::name,
        ]);
    }

    protected function initRoutes()
    {
        require __DIR__ . '/Config/routes.php';
    }

    public function run()
    {
        $request = Request::createFromBase(Request::createFromGlobals());
        return $this->handle($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    protected function handle(Request $request)
    {
        try {
            $response = $this->router->dispatch($request);

        } catch (NotFoundHttpException $e) {
            $response = new Response(['message' => 'Page not found.'], 404);

        } catch (MethodNotAllowedHttpException $e) {
            $response = new Response(['message' => 'Page not found.'], 404);
        }

        $response->sendHeaders();
        $response->send();

        return $response;
    }
}
