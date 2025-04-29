<?php

namespace app\service\Router;

interface IRequest
{
    public static function capture(): self;
    public function setMiddlewares(array $middlewares): void;

    public function getMiddlewares(): array;

    public function getUrL(): string;

    public function getAction(): string;

    public function getActionName(): string;

    public function getController(): string;

    public function getNamespace(): string;

    public function isHome(): bool;

    public function isAdmin(): bool;

    public function getControllerFullName(): string;

    public function getControllerName(): string;

    public function getHost(): string;
    }