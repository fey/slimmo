<?php

namespace App;

use Slim\App;

/** @mixin App */
class Rest
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public static function create(App $app): self
    {
        return new self($app);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->$name(...$arguments);
        }

        return $this->app->$name(...$arguments);
    }

    public function resource(string $resource, string $controllerName)
    {
        $this->app->get("/$resource", [$controllerName, 'index']);
        $this->app->get("/$resource/{id}", [$controllerName, 'show']);
        $this->app->post("/$resource", [$controllerName, 'store']);
        $this->app->put("/$resource/{id}", [$controllerName, 'update']);
        $this->app->delete("/$resource/{id}", [$controllerName, 'destroy']);
    }
}