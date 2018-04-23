<?php

namespace app\components;


class Route
{
    public $alias;
    public $internalRoute; // route is in form SomeController@action
    public $method;
    public $params;

    /**
     * Route constructor.
     * @param $alias
     * @param $internalRoute
     * @param $method
     * @param $params
     */
    public function __construct($alias, $internalRoute, $method, array $params = array())
    {
        $this->alias = $alias;
        $this->internalRoute = $internalRoute;
        $this->method = $method;
        $this->params = $params;
    }
}