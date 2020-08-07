<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/13/2018
 * Time: 12:52 PM
 */

namespace App\Repositories;
use App\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Config;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function getAll()
    {
        return $this->model::orderBy(
            'id', Config::get('settings.admin.articles.orderBy')
        )->paginate(Config::get('settings.admin.articles.paginate'));

    }

    public function getAllNoPagination()
    {
        return $this->model::all();
    }

    public function getByID($id)
    {
        return $this->model::findOrFail($id);
    }

    public function deleteItem($id)
    {
        return $this->model::findOrFail($id)->delete();
    }

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

    public static function deleteImage($path, $fileName)
    {

        $path = trim($path, '/');

        if($fileName && file_exists($path . '/' . $fileName)){
            unlink($path . '/' . $fileName);
        }
    }
}