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
        $resourcesPath = str_replace('.', '/', $resource);
        $this->app->get("/$resourcesPath", [$controllerName, 'index'])
            ->setName("$resource.index");
        $this->app->get("/$resourcesPath/{id}", [$controllerName, 'show'])
            ->setName("$resource.show");
        $this->app->post("/$resourcesPath", [$controllerName, 'store'])
            ->setName("$resource.store");
        $this->app->put("/$resourcesPath/{id}", [$controllerName, 'update'])
            ->setName("$resource.update");
        $this->app->delete("/$resourcesPath/{id}", [$controllerName, 'destroy'])
            ->setName("$resource.destroy");
    }
}