<?php

namespace app\core;

use Dotenv\Dotenv;
use Exception;
use ReflectionClass;
use ReflectionNamedType;

class Route
{
    public function run()
    {
        $this->init();

        $parseUrl = explode('?', $_SERVER['REQUEST_URI']);
        $routes = explode('/', $parseUrl[0]);

        $version = $routes[1] ?? 'v1';
        $controller = $routes[2] ?? null;
        $action = $routes[3] ?? null;

        $controllerName = 'app\\modules\\'.$version.'\\controllers\\'.ucfirst($controller).'Controller';
        if (!class_exists($controllerName)) {
            throw new Exception('Method is not found');
        }

        $actionResult = $this->callAction($controllerName, $action);

        // Response
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($actionResult);
    }

    private function callAction(string $controller, string $action)
    {
        $actionControllerObject = new $controller();
        $actions = $actionControllerObject->actions();

        if (!isset($actions[$action])) {
            throw new Exception('Action is not found');
        }
        $actionOptions = $actions[$action];
        $actionClass = $actionOptions['class'] ?? ($actionOptions[$_SERVER['REQUEST_METHOD']]['class'] ?? null);

        if (!class_exists($actionClass)) {
            throw new Exception('Action is not found');
        }

        // controller
        $actionControllerObject->beforeAction($actionOptions);

        // action
        $actionObject = new $actionClass($actionOptions);
        $actionObject->init();
        $actionObject->beforeRun();

        return call_user_func_array([$actionObject, 'run'], self::getReflectionArgs($actionClass, 'run'));
    }

    private static function getReflectionArgs($controller, $actionName): array
    {
        $reflector = new ReflectionClass($controller);
        $parameters = $reflector->getMethod($actionName)->getParameters();
        $args = [];
        foreach ($parameters as $param) {
            if ($param->isDefaultValueAvailable() && !isset(self::getArguments()[$param->getName()])) {
                $args[$param->getName()] = $param->getDefaultValue();
                continue;
            }

            if ($param->allowsNull() && !isset(self::getArguments()[$param->getName()])) {
                $args[$param->getName()] = null;
                continue;
            }

            if ($param->isOptional() === false && !isset(self::getArguments()[$param->getName()])) {
                throw new Exception($param->getName().' is required');
            }

            $argument = self::getArguments()[$param->getName()];

            if ($param->hasType()) {
                $isValidNull = $param->allowsNull() && $argument === '';
                if ($isValidNull) {
                    $argument = null;
                }

                /* @var $type ReflectionNamedType */
                $type = $param->getType();

                $typeName = $type->getName();

                if ($typeName == 'int' && !self::is_int($argument) && !$isValidNull) {
                    throw new Exception($param->getName().' must be of type integer'.self::getNullMsg($param->allowsNull()));
                }
                if ($typeName == 'string' && !is_string($argument) && !$isValidNull) {
                    throw new Exception($param->getName().' must be of type '.$typeName.self::getNullMsg($param->allowsNull()));
                }
                if (in_array($typeName, ["bool", "boolean"], true) && in_array($argument, ['true', 'false'], true)) {
                    $argument = $argument === 'true'; // Поддержка true false в key=value запросах.
                }
                if (in_array($typeName, ["bool", "boolean"], true) && !in_array($argument, [true, false, 0, 1, '0', '1'], true) && !$isValidNull) {
                    throw new Exception($param->getName().' must be of type '.$typeName.self::getNullMsg($param->allowsNull()));
                }
                if ($typeName == 'float' && !self::is_string_float($argument) && !self::is_int($argument) && !$isValidNull) {
                    throw new Exception($param->getName().' must be of type boolean'.self::getNullMsg($param->allowsNull()));
                }

                if ($param->isArray() === true && !is_array($argument) && !$isValidNull) {
                    throw new Exception($param->getName().' must be of type '.$typeName.self::getNullMsg($param->allowsNull()));
                }
            }

            $args[$param->getName()] = $argument;
        }

        return $args;
    }

    private function init()
    {
        date_default_timezone_set('Europe/Moscow');

        if (file_exists('./.env')) {
            (Dotenv::createUnsafeImmutable('./'))->load();
        }

        Container::init();
    }

    private static function getArguments(): array
    {
        $actionArgs = [];
        if (isset($_POST) || isset($_GET)) {
            $actionArgs = array_merge($_POST, $_GET);
        }

        return $actionArgs;
    }

    private static function is_int($value): bool
    {
        return (is_numeric($value) ? intval($value) == $value : false);
    }

    private static function getNullMsg($isShow = false): string
    {
        return $isShow ? ' or empty' : '';
    }

    private static function is_string_float($string): bool
    {
        if (is_numeric($string)) {
            $val = $string+0;

            return is_float($val);
        } else {
            return false;
        }
    }
}