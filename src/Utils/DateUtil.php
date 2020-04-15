<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

use DateTime;

/**
 * Description of DateUtil
 *
 * @author Balika
 */
class DateUtil {

    /**
     * 
     * @param DateTime $datePosted
     * @return string
     * @description returns a nice date format that is more reflective of how long ago a post or entry was made into the database
     */
    public static function getNiceDate(DateTime $datePosted) {
        $now = new DateTime("now");
        $interval = $datePosted->diff($now);
        $when = "";
        if ($interval->s > 0) {
            $when = 'a few seconds ago';
        } elseif ($interval->i > 0) {
            $when = $interval->i == 1 ? ' a minute ago' : $interval->i . ' minutes ago';
        } elseif ($interval->h > 0) {
            $when = $interval->h == 1 ? ' an hour ago' : $interval->h . ' hours ago';
        } elseif ($interval->d > 0) {
            $when = $interval->d == 1 ? ' a day ago' : $interval->d . ' days ago';
        } elseif ($interval->m > 0) {
            $when = $interval->m == 1 ? ' a month ago' : $interval->m . ' months ago';
        } elseif ($interval->y > 0) {
            $when = $interval->y == 1 ? ' a year ago' : $interval->y . ' years ago';
        }
        return $when;
    }

    /**
     * 
     * @param DateTime $datePosted
     * @return string
     * @description returns a nice date format that is more reflective of how long ago a post or entry was made into the database
     */
    public static function getPrettyDate(DateTime $datePosted = null) {
        return $datePosted ? $datePosted->format(("j M, Y")) : "";
    }

    /**
     * 
     * @param DateTime $datePosted
     * @return string
     * @description returns a nice date format that is more reflective of how long ago a post or entry was made into the database
     */
    public static function getPrettyDateWithTime(DateTime $datePosted = null) {
        return $datePosted ? $datePosted->format(("j M, Y - g:i a")) : "";
    }

}
