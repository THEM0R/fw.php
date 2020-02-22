<?php

namespace module;
use module\Helper;

class Request
{

    public static function getUrl()
    {
        $url = trim($_SERVER['REQUEST_URI']);

        $pos = strpos($_SERVER['REQUEST_URI'], '?');

        if ($pos) {
            $url = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }

        $url = trim($url, '/');

        return $url;
    }

    /**
     * addRequestParameters
     */
    public static function addRequestParameters()
    {
        if ($_GET !== []) {
            $url = '?';
            foreach ($_GET as $key => $value) {
                $url .= $key . '=' . $value . '&';
            }
            $url = rtrim($url, '&');

            Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
        }
    }

    /**
     * SERVER REQUEST_METHOD
     */
    public static function addMethod($route)
    {
        if ($route['method']['name'] !== $_SERVER['REQUEST_METHOD']) {
            Helper::notFound('REQUEST_METHOD не співпадає');
        }
        if ($route['method']['name'] == 'GET') {
            $route['method']['data'] = Helper::array_clear($_GET);
        } else if ($route['method']['name'] == 'POST') {
            $route['method']['data'] = Helper::array_clear($_POST);
        }

        return $route;
    }


    /**
     * @param $url
     * redirect to request
     */
    private function request($url)
    {
        if (strpos($url, '/') !== false) {


            if (strpos($url, '&') !== false) {

                $url_request = explode('&', $url)[0];
                $url = explode('&', $url)[1];

            }
        }


        if (strpos($url, '&') !== false | strpos($url, '=') !== false) {
            if (strpos($url, 'request') === false) {
                if (SL) {
                    if (!in_array(explode('/', $url)[1], LANGUAGES)) {
                        $url = explode('/', $url)[1];
                    }
                }

                if (strpos($url, '&') === 0) {
                    $url = substr($url, 1);
                }

                Helper::redirect(DOMEN . '/request/' . '&' . $url);
            }
        }
    }
}