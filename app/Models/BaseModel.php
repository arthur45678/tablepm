<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public static function createSlug($aliasName = false)
    {
        $alias = null;
        if(empty($aliasName)){
            $alias = (int) microtime(true);
        }elseif ($aliasName){
            /*Begin */
            // $alias = self::transliterate($aliasName);

            $str = mb_strtolower($aliasName, 'UTF-8');

            $letter_array = array(
                'a' => 'а,ա',
                'b' => 'б,բ',
                'v' => 'в,վ',
                'g' => 'г,ґ,գ',
                'h' => 'հ',
                'd' => 'д, դ',
                'dz' => 'ձ',
                'e' => 'е,є,э,ե,է',
                'ev' => 'և',
                'jo' => 'ё',
                'zh' => 'ж,ժ',
                'z' => 'з,զ',
                'i' => 'и,і,ի',
                'ji' => 'ї',
                'j' => 'й,յ,ջ',
                'k' => 'к,կ',
                'l' => 'л,լ',
                'm' => 'м,մ',
                'n' => 'н,ն',
                'o' => 'о,ո,օ',
                'p' => 'п,պ,փ',
                'r' => 'р,ռ,ր',
                's' => 'с,ս',
                't' => 'т,թ,տ',
                'u' => 'у,ւ',
                'f' => 'ф,ֆ',
                'kh' => 'х,խ,ղ',
                'ts' => 'ц,ծ,ց',
                'ch' => 'ч,ճ,չ',
                'sh' => 'ш,շ',
                'shch' => 'щ',
                '' => 'ъ,ը',
                'y' => 'ы',
                '' => 'ь',
                'q' => 'ք',
                'yu' => 'ю',
                'ya' => 'я',
            );

            foreach($letter_array as $leter => $kyr) {
                $kyr = explode(',',$kyr);

                $str = str_replace($kyr,$leter, $str);

            }

            //  A-Za-z0-9-
            $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','-',$str);

            $str = trim($str,'-');
            /*end*/
            $alias = mb_strimwidth($str, 0, 40);
        }
        return $alias;
    }
}
