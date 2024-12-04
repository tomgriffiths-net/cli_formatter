<?php
class cli_formatter{
    public static function command($line){

    }
    public static function fill(string $colour, int $width=120, int $height=29):void{
        self::clear();
        $string = '';
        $i = 1;
        while($i < $height+1){
            $string .= str_repeat(" ",$width);
            if($i < $height){
                $string .= "\n";
            }
            $i++;
        }
        echo self::formatLine($string,$colour,false,true,"reverse");
    }
    public static function ding():void{
        echo "\007";
    }
    public static function formatLine(string $string, string|bool $colour = false, string|bool $background = false, bool $newline = true, string|bool $attributes = false):string{
        
        $colourValues = array(
            'bold'         => '1',    'dim'          => '2',
            'black'        => '0;30', 'dark_gray'    => '1;30',
            'blue'         => '0;34', 'light_blue'   => '1;34',
            'green'        => '0;32', 'light_green'  => '1;32',
            'cyan'         => '0;36', 'light_cyan'   => '1;36',
            'red'          => '0;31', 'light_red'    => '1;31',
            'purple'       => '0;35', 'light_purple' => '1;35',
            'brown'        => '0;33', 'yellow'       => '1;33',
            'light_gray'   => '0;37', 'white'        => '1;37',
            'normal'       => '0;39'
        );
        $backgroundValues = array(
            'black'        => '40',   'red'          => '41',
            'green'        => '42',   'yellow'       => '43',
            'blue'         => '44',   'magenta'      => '45',
            'cyan'         => '46',   'light_gray'   => '47',
        );
        $attributeValues = array(
            'underline'    => '4',    'blink'        => '5', 
            'reverse'      => '7',    'hidden'       => '8',
        );
    
        $output = '';
    
        if($colour !== false){
            if(isset($colourValues[$colour])){
                $output .= "\033[";
                $output .= $colourValues[$colour] . "m";
            }
        }
    
        if($background !== false){
            if(isset($backgroundValues[$background])){
                $output .= "\033[";
                $output .= $backgroundValues[$background] . "m";
            }
        }
    
        if($attributes !== false){
            $attributesArray = array();
            if(strpos($attributes,",") !== false){
                $attributesArray = explode(",",$attributes);
            }
            else{
                $attributesArray[0] = $attributes;
            }
            foreach($attributesArray as $attribute){
                if(isset($attributeValues[$attribute])){
                    $output .= "\033[";
                    $output .= $attributeValues[$attribute] . "m";
                }
            }
        }
    
        $output .= $string . "\033[0m";
    
        if($newline){
            $output .= "\n";
        }
    
        return $output;
    }
    public static function clear():void{
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
    }
}