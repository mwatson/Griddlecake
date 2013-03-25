<?php
namespace Griddlecake;

//
// The Baker class created a Griddlecake template, though it's not necessary 
// to have it to use Griddlecake. You can easily just save the static CSS and 
// use that, and in fact that's probably what you should do.

// There are a bunch of static functions because that seems like the cool thing 
// to do. You can pretty much ignore all of them.

// Baker::bake() is the only public method and it barfs out some CSS based on 
// two GET variables: 'step' and 'compressed'.

// 'step' is the percentages used, with the default being 5

// 'compressed' being set will wipe out all non-essential text like comments and 
//     spaces if you're super into saving space

// Running the class is fun and easy:
// \Griddlecake\Baker::bake();

// You can also set the step and compression manually since they're public:
//
// \Griddlecake\Baker::$step = 10;
// \Griddlecake\Baker::$compressed = true;
// \Griddlecake\Baker::bake();
//


class Baker {

        public static $step = 5;
        public static $compressed = false;

        private static function getConfig() {
        
                if(isset($_GET['step'])) {
                        static::$step = $_GET['step'];
                }
                
                if(isset($_GET['compressed'])) {
                        static::$compressed = true;
                }
                
                if(!is_numeric(static::$step)) {
                        static::$step = 5;
                }
                
                if(static::$step > 100) {
                        static::$step = 5;
                }
                
                if(static::$step < 0) {
                        static::$step = 5;
                }
        }

        public static function bake() {
        
                static::getConfig();
                
                $steps = array();
                $thirds = array(33 => false, 34 => false);
                
                for($i = static::$step; $i < 100; $i += static::$step) {
                        $steps[] = ".col{$i} { float: left; width: {$i}%; }";
                        if($i == 33) $thirds[33] = true;
                        if($i == 34) $thirds[34] = true;
                }
                        
                $steps[] = ".col100, .row { float: left; width: 100%; }";
                
                ob_start();
                if(file_exists(__DIR__.'/cssTemplate.php')) {
                        include(__DIR__.'/cssTemplate.php');
                }
                $css = ob_get_clean();
                
                if(static::$compressed) {
                        $css = static::compress($css);
                }
                
                static::output($css);
        }
        
        private static function compress($css) {
                $css = str_replace(' ', '', trim($css));
                $css = preg_replace('|\/\*(.+)\*\/|', '', $css);
                $css = str_replace("\n", "", $css);
                $css = str_replace("\r", "", $css);
                
                return $css;
        }
        
        private static function output($css) {
                header('Content-type: text/css');
                echo $css;
                exit();
        }
}
