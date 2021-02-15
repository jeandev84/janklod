<?php

use Jan\Component\Config\Config;
use Jan\Component\Container\Container;
use Jan\Component\Container\Exception\BindingResolutionException;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Router;
use Jan\Component\Templating\Asset;



# APPLICATION
if(! function_exists('app'))
{

    /**
     * @param string|null $abstract
     * @param array $parameters
     * @return Container
     * @throws ReflectionException
     * @throws BindingResolutionException
    */
    function app(string $abstract = null, array $parameters = []): Container
    {
        $app = Container::getInstance();

        if(is_null($abstract))
        {
            return $app;
        }

        return $app->make($abstract, $parameters);
    }
}

/* dump(Container::getInstance()); */


if(! function_exists('base_path'))
{
     /**
      * Base Path
      * @param string $path
      * @return string
      * @throws BindingResolutionException
      * @throws ReflectionException
    */
    function base_path($path = '')
    {
        return app()->get('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


if(! function_exists('config'))
{
    /**
     * Config
     * @param string $key
     * @return string
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    function config($key = '')
    {
        return app()->get(Config::class)->get($key);
    }
}

# ENVIRONMENT
if(! function_exists('env'))
{
    /**
     * Get item from environement or default value
     *
     * @param $key
     * @param null $default
     * @return array|bool|false|string|null
    */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if(! $value)
        {
            return $default;
        }

        return $value;
    }
}



if(! function_exists('app_name'))
{
    /**
     * Application name
     * @return string
     * @throws BindingResolutionException
     * @throws ReflectionException
    */
    function app_name()
    {
         return \config('app.name');
    }
}


# ROUTING
if(! function_exists('route'))
{

    /**
     * @param $name
     * @param array $params
     * @return string
     * @throws Exception
    */
    function route($name, $params = []): string
    {
        return app()->get(Router::class)->generate($name, $params);
    }
}



# HTTP REQUEST / RESPONSE
if(! function_exists('response'))
{

    /**
     * @param $content
     * @param int $code
     * @param array $headers
     * @return Response
    */
    function response($content, $code = 200, $headers = []): Response
    {
        return new Response($content, $code, $headers);
    }
}


if(! function_exists('redirect'))
{

    /**
     * @param $to
     * @return void
    */
    function redirect($to)
    {
         // exit;
    }
}


# FUNCTIONS TEMPLATING
if(! function_exists('view'))
{

    /**
     * @param string $name
     * @param array $data
     * @return Response
     * @throws BindingResolutionException
     * @throws ReflectionException
    */
    function view(string $name, array $data = [])
    {
        $template = app()->get('view')->render($name, $data);
        return new Response($template, 200);
    }
}


if(! function_exists('asset'))
{

    /**
     * @param string $link
     * @throws Exception
     * @return string
    */
    function asset(string $link)
    {
         $asset = app()->get(Asset::class);

         $parts = explode('.', $link);
         $ext = end($parts);

         switch ($ext)
         {
             case 'css':
                 return $asset->renderOnceCss($link);
                 break;
             case 'js':
                 return $asset->renderOnceJs($link);
                 break;
             default:
                 return $asset->generateUrl($link);
                 break;
         }
    }
}




if(! function_exists('renderCss'))
{
    /**
     * @throws Exception
     * @return string
    */
    function renderCss()
    {
        return \asset()->renderCss();
    }
}



if(! function_exists('renderJs'))
{
    /**
     * @throws Exception
     * @return string
    */
    function renderJs()
    {
        return \asset()->renderJs();
    }
}