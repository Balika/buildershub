<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Entity\Notification;
use App\Entity\User;

/**
 *
 * @author Balika - BTL
 */
interface MessagingInterface {

    public function sendSMS($recipientNumber, $message);

    public function sendEmail($message);

    public function sendAccountActivationMessage(User $user);

    public function sendInvitationEmails(User $user);

    public function sendNotification(Notification $notification);
}
