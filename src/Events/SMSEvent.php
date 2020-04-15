<?php
namespace App\Events;

use App\Entity\User;
use App\Events\BaseUserEvents;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchoolRegisteredEvent
 *
 * @author Edmond
 */
class SMSEvent extends BaseUserEvents{
    const NAME = 'send.sms.requested';
      
   
}
