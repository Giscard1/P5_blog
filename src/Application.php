<?php


namespace App;

use App\Application\Http\Request;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    protected RouteCollection $routeCollection;

    public function __construct()
    {
        $this->initRouter();
    }


    public function run(ServerRequestInterface $request)
    {
        try{

            $context = new RequestContext();
            $context->setPathInfo($request->getUri()->getPath());
            $queryParams = $request->getQueryParams();
            $matcher = new UrlMatcher($this->routeCollection, $context);

            $parametersRoute = $matcher->match($request->getUri()->getPath());
            $controller = $parametersRoute['_controller'];
            $method = $parametersRoute['_method'];
            unset($parametersRoute['_method']);
            unset($parametersRoute['_controller']);
            unset($parametersRoute['_route']);
            $callable = [new $controller(), $method];

            return call_user_func_array($callable, [$request, $parametersRoute]);

        } catch (ResourceNotFoundException $e) {

            //TODO Create exception controller to return 404
        } catch (MethodNotAllowedException $e){

            //TODO Create exeption controller to return not allowed
        } catch (\Throwable $e) {

            //TODO create exeception to retuen internal error
        }

    }

    private function initRouter()
    {
        $this->routeCollection = new RouteCollection();
        $routes = json_decode(file_get_contents(__DIR__.'/../config/routing/routes.json'),true);

        foreach($routes as $route) {
            $this->routeCollection->add(
                $route['name'],
                new Route(
                    $route['path'],
                    ['_controller' => $route['_controller'], '_method' => $route['_method']],
                    [],
                    [],
                    '',
                    [],
                    $route['_methods']
                )
            );
        }
    }
}
