<?php

namespace App\Twig;

use App\Utils\DateUtil;
use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HubExtensions
 *
 * @author Balika
 */
class HubExtensions extends AbstractExtension {

    public function getFilters() {
        return [
            new TwigFilter('when', [$this, 'formatDate']),
            new TwigFilter('pretty_date', [$this, 'formatPrettyDate']),
            new TwigFilter('pretty_date_with_time', [$this, 'formatPrettyDateWithTime']),
            new TwigFilter('isPhoneNumber', [$this, 'validPhoneNumber']),
        ];
    }

    public function getFunctions() {
        return[
            new TwigFunction('order_items', [HubRuntime::class, 'getOrderItems']),
            new TwigFunction('hubernize_host', [HubRuntime::class, 'hubernizeHost']),
            new TwigFunction('is_subscribed_to_app', [HubRuntime::class, 'isSubscribedToApp']),
            new TwigFunction('is_liked', [ProfileRuntime::class, 'isLiked'])
        ];
    }

    public function formatDate(DateTime $datePosted) {
        return DateUtil::getNiceDate($datePosted);
    }

    public function formatPrettyDate(DateTime $datePosted = null) {
        return DateUtil::getPrettyDate($datePosted);
    }

    public function formatPrettyDateWithTime(DateTime $datePosted = null) {
        return DateUtil::getPrettyDateWithTime($datePosted);
    }

    /**
     * <p>Checks to see if <i>$number</i> is a valid phone number or not.</p><br />
     * @param string $number <p>The value to check whether it is a valid phone number or not.</p><br />
     * @return boolean <i>true</i> if <i>$number</i> is a valid phone number otherwise it returns <i>false</i>.
     */
    public function validPhoneNumber($number) {
        return preg_match("/^\+?[0-9]{8,15}$/", $number) > 0 ? $number : '';
    }

}
