<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Snape\EcoSystemWP\Controllers\AbstractController;

class WordPressControllerServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        add_filter('template_include', array($this, 'handleTemplateInclude'));
    }

    public function handleTemplateInclude(string $template): string
    {
        include $template;

        $controller = $this->getControllerClassFromTemplate($template);

        $controllerInstance = new $controller();
        if (! is_subclass_of($controllerInstance, AbstractController::class)) {
            throw new \Exception(
                sprintf(
                    '%s class is not a child of %s',
                    $controllerInstance,
                    AbstractController::class
                )
            );
        }

        $controllerInstance->renderPage();

        return $template;
    }

    public function getControllerClassFromTemplate(string $template): string
    {
        $controllerName = $this->extractNamespace($template);

        //Return 404 if Controller is the 404
        if ($controllerName === '404Controller') {
            $controllerName = 'Error' . $controllerName;
        }

        return $controllerName;
    }

    /**
     * Extract namespace from a PHP file
     *
     * @param  string  $file
     *
     * @return string
     */
    public function extractNamespace(string $file): string
    {
        $contents = file_exists($file) ? file_get_contents($file) : $file;
        $namespace = $class = '';
        $getting_namespace = $getting_class = false;

        foreach (token_get_all($contents) as $token) {
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                $getting_namespace = true;
            }

            if (is_array($token) && $token[0] === T_CLASS) {
                $getting_class = true;
            }

            // While we're grabbing the namespace name...
            if ($getting_namespace === true) {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR], true)) {
                    $namespace .= $token[1];
                } elseif ($token === ';') {
                    $getting_namespace = false;
                }
            }

            if (($getting_class === true) && is_array($token) && $token[0] === T_STRING) {
                $class = $token[1];
                break;
            }
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }
}
