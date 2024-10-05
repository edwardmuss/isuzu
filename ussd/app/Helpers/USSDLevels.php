<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-02
 * Time: 13:57
 */

namespace App\Helpers;


class USSDLevels
{
    public static function levelZero(){

    }

    public static function levelOne($string){
        switch ($string){
            case 1:
                return USSDPages::pageOne();
                break;
            case 2:
                return USSDPages::pageTwo();
                break;
            case 3:
                return USSDPages::pageThree();
                break;
            case 4:
                return USSDPages::pageFour();
                break;
            case 5:
                return USSDPages::pageFive();
                break;
            case 6:
                return USSDPages::pageSix();
                break;
            case 7:
                return USSDPages::pageSeven();
                break;
            case 8:
                return USSDPages::pageEight();
                break;
            case 9:
                return USSDPages::pageNine();
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwo($implode, $explode){
        $sub_string = substr($implode, 0 , 2);
        switch ($sub_string){
            case "1":
                return self::levelTwoOne($explode);
                break;
            case "2":
                return self::levelTwoTwo($explode);
                break;
            case "3":
                return self::levelTwoThree($explode);
                break;
            case "4":
                return self::levelTwoFour($explode);
                break;
            case "5":
                return self::levelTwoFive($explode);
                break;
            case "6":
                return self::levelTwoSix($explode);
                break;
            case "7":
                return self::levelTwoSeven($explode);
                break;
            case "8":
                return self::levelTwoEight($explode);
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwoOne($explode){
        switch ($explode[1]){
            case 1:
                return USSDPages::pageOneOne();
                break;
            case 1:
                return USSDPages::pageOneTwo();
                break;
            case 1:
                return USSDPages::pageOneThree();
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwoTwo($explode){
        switch ($explode[1]){
            case 1:
                return USSDPages::pageTwoOne();
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwoThree($explode){
        return USSDPages::pageThreeOne();
    }

    public static function levelTwoFour($explode){
        switch ($explode[1]){
            case 1:
                return USSDPages::pageFourOne();
                break;
            case 2:
                return USSDPages::pageFourTwo();
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwoFive($explode){

    }

    public static function levelTwoSix($explode){

    }

    public static function levelTwoSeven($explode){
        switch ($explode[1]){
            case 1:
                return USSDPages::pageName();
                break;
            case 2:
                return USSDPages::pageName();
                break;
            case 3:
                return USSDPages::pageName();
                break;
            case 4:
                return USSDPages::pageName();
                break;
            case 5:
                return USSDPages::pageName();
                break;
            case 6:
                return USSDPages::pageName();
                break;
            case 7:
                return USSDPages::pageName();
                break;
            case 8:
                return USSDPages::pageName();
                break;
            default:
                return "END Error";
        }
    }

    public static function levelTwoEight($explode){
        switch ($explode[1]){
            case 1:
                return USSDPages::pageNxxame();
                break;
            case 2:
                return USSDPages::pageName();
                break;
            default:
                return "END Error";
        }
    }
}
