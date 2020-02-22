<?php
namespace module;
use module\Helper;
use module\Request;

class Language
{
    private static $sl = 1; // severalLanguages

    const SL = 0;

    public function __construct()
    {
        pr1(SL);
    }

    public static function LangToPattern($pattern)
    {

        if (self::$sl) {

            if ($pattern == '') {
                $pattern = '(language:str)' . $pattern;
            } else {
                $pattern = '(language:str)/' . $pattern;
            }
        }

        return $pattern;
    }

    public static function langRedirect($url){

        if (self::$sl) { // SEVERAL_LANGUAGES -- РІЗНІ МОВИ

            /** якшо в $url пусто */
            if ($url === '') {
                Request::addRequestParameters();
                Helper::redirect(DOMEN . '/' . LANGUAGE);
            }

            if (!in_array($url, LANGUAGES)) {

                if (strpos($url, '/') !== false) {

                    if (strpos($url, '/') !== strlen(LANGUAGE)) {
                        Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
                    }
                } else {
                    if (in_array(substr($url, 0, 2), LANGUAGES)) {
                        $url = substr($url, 2);
                    }
                    if (strpos($url, '&') === 0) {
                        $url = substr($url, 1);
                    }
                    Helper::redirect(DOMEN . '/' . LANGUAGE . '/' . $url);
                }
            }


        } else { // SEVERAL_LANGUAGES -- РІЗНІ МОВИ


            if (in_array(substr($url, 0, 2), LANGUAGES)) {

                $url = substr($url, 2);

                if (strpos($url, '/') === 0) {
                    $url = substr($url, 1);
                }
                Helper::redirect(DOMEN . '/' . $url);
            }
        }
    }

}