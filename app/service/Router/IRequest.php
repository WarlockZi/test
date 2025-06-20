<?php

namespace app\service\Router;

interface IRequest
{
    public static function capture(): self;
    public function setMiddlewares(array $middlewares): void;

    public function middlewares(): array;

    public function urL(): string;

    public function action(): string;

    public function actionName(): string;

    public function controller(): string;

    public function namespace(): string;

    public function isHome(): bool;

    public function isAdmin(): bool;

    public function controllerFullName(): string;

    public function controllerName(): string;

    public function host(): string;
    public function toArray(): array;
    }