<?php

namespace mvc;

use DateTime;
use lang\Language;
use core\DB;
use lib\App;


abstract class Controller
{

    public $meta = [];

    /*
     * @array $route
     * текущий маршрут
     */
    public $route = null;
    public $controller = null;

    /*
     * @var $view
     * текущий вид
     */
    public $view = null;

    /*
     * @var $templates
     * текущий шаблон
     */
    public $theme = null;

    /*
     * @array $templates
     */
    public $vars = null;




    public $configs = [

        'menu'  => [
            1 => [
                'url' => '',
                'name' => 'Головна'
            ],
            2 => [
                'url' => 'material',
                'name' => 'Матеріали'
            ],
            3 => [
                'url' => 'metal',
                'name' => 'Металопрокат'
            ],
            4 => [
                'url' => 'gallery',
                'name' => 'Галерея'
            ],
            5 => [
                'url' => 'about',
                'name' => 'Про нас'
            ],
//            5 => [
//                'url' => 'contact',
//                'name' => 'Контакти'
//            ],
        ],
        'sity' => [

            'Болехів',
            'Бурштин',
            'Галич',
            'Городенка',
            'Долина',
            'Івано-Франківськ',
            'Калуш',
            'Коломия',
            'Косів',
            'Надвірна',
            'Рогатин',
            'Рожнятів',
            'Тисмениця',
            'Тлумач',
            'Яремче',

            'Сваричів',
            'Перегінськ',
        ],
        'products'  => [

            'блок-хаус',
            'Профнастил',
            'Євро-брус',
            'Металочерепиця',
            'Штахетник',
            'Лист',

            'Арматура',
            'Квадрат',
            'Круг',
            'Труби',
            'Труби водогазопровідні',
            'Швелер',
            'Кутник',
            'Дріт',
            'Смуга',
            'Кладочна Сітка',
            'Профільні Труби',
            'Оцинковані Вироби',

        ],
        'description'  => 'Приватне підприємство «Металік-Плюс»<br><br>
        займається виробництвом: блок-хаусу, евро-брусу, металочерепиці, профнастилу, 
        <br>металоштахетника та аксесуарів для даху.
        <br>виконуємо комплектацію стандартних та індивідуальних рохмірів.<br><br>
        
        Завод «Металік-Плюс» знаходиться в місті Калуш, Івано-Франківської області.
        <br><br>Початок діяльності було покладено в 2007 році.<br>
        
        За 12 років свого існування фірма змогла завоювати довіру своїх клієнтів.
        <br>«Металік-Плюс» знають і поважають в Україні!.<br><br>
        
        Швидкість виконання роботи, 
        індевідуальний підхід та оптимальні ціни - це те,
        <br>що робить продукцію заводу привабливою та вигідною для покупців!',
    ];


    public function __construct($model, $route)
    {
        // route
        $this->route            = $route;

        $this->controller       = App::lowerCamelCase($route['controller']);
        $this->view             = $route['view'];
        // Language


        // theme
        if(!$this->theme) $this->theme = THEME;

        //pr1($this->configs);


    }


    public function getView()
    {
        $viewObject     = new View($this->route, $this->theme, $this->view,  $this->meta);

        if(is_dir(APP .'/views/'.$this->theme.'/')){
            $theme  = APP .'/views/'.$this->theme.'/';
        }else{
            $theme  = null;
        }

        $configs    = $this->configs;

        $meta       = $this->meta;
        $route      = $this->route;
        $controller = $this->controller;

        $all        = compact( 'theme', 'route', 'meta', 'configs', 'controller');

        if($this->vars)
        {
            $array  = array_merge($all,$this->vars);
        }
        else
        {
            $array  = $all;
        }


        // unset optimize
        unset($theme);
        unset($meta);
        unset($route);
        unset($all);

        $viewObject->rendering($array);

        // unset optimize
        unset($viewObject);
        unset($array);
    }

    public function render($vars = null)
    {
        $this->vars = $vars;

        // unset optimize
        unset($vars);
    }

    public function Meta($title = null, $description = null, $keywords = null)
    {
        $this->meta['title'] = $title ?: META_TITLE;
        $this->meta['keywords'] = $keywords ?: $this->keywords();
        $this->meta['description'] = $description ?: $this->configs['description'];

        // unset optimize
        unset($title);
        unset($keywords);
        unset($description);
    }

    public function keywords(){

        $string = null;

        foreach ($this->configs['products'] as $tiem){
            $string .= $tiem.',';
        }

        foreach ($this->configs['sity'] as $sity){

            foreach ($this->configs['products'] as $tiem){
                $string .= $sity.' '.$tiem.',';
            }


        }

        return rtrim($string,',');

    }











}