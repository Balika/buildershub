<?php

namespace App\Services;

/* * use BasicAuth;
  use HttpResponse;
  use MessageResponse;
  use MessagingApi; */

use ApiHost;
use App\Entity\Notification;
use App\Entity\User;
use App\Events\ForgottenPasswordEvent;
use App\Events\UserAccountCreatedEvent;
use App\Model\MessagingInterface;
use App\Utils\Constants;
use App\Utils\EntityConfig;
use BasicAuth;
use HttpResponse;
use MessageResponse;
use MessagingApi;
use Swift_Mailer;
use Swift_Message;
use Doctrine\Persistence\ManagerRegistry as Doctrine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Exception\Exception;
use Twig_Environment;

class MessagingService implements EventSubscriberInterface, MessagingInterface {

    protected $doctrine;
    private $templating;
    private $mailer;
    private $mailerConfig;
    protected $apiKey;
    protected $apiSecret;
    private $twilio;

    public function __construct(Doctrine $doctrine, Twig_Environment $templating, Swift_Mailer $mailer, $twilio, $apiKey, $apiSecret) {
        $this->doctrine = $doctrine;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->twilio = $twilio;
    }

    public static function getSubscribedEvents() {
        return array(
            UserAccountCreatedEvent::class => 'sendAccountActivationMessage',
            ForgottenPasswordEvent::class => 'onPasswordResetRequest'
        );
    }

    public function sendEmail($message) {
       return $this->mailer->send($message);       
    }

    public function sendSMS($recipientNumber, $message) {
        $codedNumber = preg_replace('/^0/', Constants::DEFAULT_COUNTRY_PHONE_CODE, $recipientNumber);
        //$this->sendSMSWithHubtel($codedNumber, $message);
        $this->sendSMSWithTwilio($codedNumber, $message);
    }

    public function sendAccountActivationMessage(User $user) {
        $token = $user->getConfirmationToken();
        $username = $user->getUsername();
        if ($this->isValidEmail($username) || $this->isValidEmail($user->getEmail())) {
            $subject = "BuildersHub Account Activation";
            $recipient = $this->isValidEmail($username) ? $username : $user->getEmail();
            $body = $this->templating->render(
                    'emails/account.confirmation.html.twig', array('user' => $user, 'token' => $token)
            );
            $this->sendEmail($this->composeEmail($recipient, $subject, $body));
        } elseif (self::isValidPhoneNumber($username)) {
            $message = $token;
            $this->sendSMS($username, $message);
        }
    }

    public function sendInvitationEmails(User $user) {
        $invitations = $this->doctrine->getRepository(EntityConfig::INVITATION)->findBy(['invitedBy' => $user, 'hasResponded' => FALSE, 'isSent' => FALSE]);
        $em = $this->doctrine->getManager();
        foreach ($invitations as $invitation) {
            $subject = 'Invitation to BuildersHub';
            $recipient = $invitation->getEmail();
            $body = $this->templating->render('emails/hub.invitation.html.twig', array('user' => $user, 'token' => $this->generateResetToken(), 'invitation' => $invitation
            ));
            $message = $this->composeEmail($recipient, $subject, $body);
            if ($message) {
                $sent = $this->sendEmail($message);
            }
            if ($sent) {
                $invitation->setIsSent($sent);
                $em->persist($invitation);
            }
        }
        $em->flush();
    }

    private function composeEmail($recipient, $subject, $body, $contentType = "text/html") {
        if ($this->isValidEmail($recipient)) {
            $message = (new Swift_Message($subject));
            return $message->setFrom(Constants::SENDER_EMAIL_ACCOUNT, Constants::APP)
                            ->setSubject($subject)
                            ->setTo($recipient)
                            ->setBody($body, $contentType);
        }
        return null;
    }

    public function sendForgottenPasswordEmail(User $user, $token) {
        $body = $this->templating->render('emails/forgotten.password.html.twig', array('user' => $user, 'token' => $token));
             $message = $this->composeEmail($user->getEmail(), 'BuildersHub User Password Reset', $body);
        if ($message) {
            $this->sendEmail($message);
        }
    }

    public function sendNotification(Notification $notification) {
        $body = $this->templating->render('emails/notification.tpl.html.twig', ['notification' => $notification]);
        $message = $this->composeEmail($notification->getEmailedTo(), $notification->getSubject(), $body);
        if ($message) {
            $this->sendEmail($message);
        }
        $this->sendSMS($notification->getSmsTo(), $notification->getBody());
    }

    public function onPasswordResetRequest(ForgottenPasswordEvent $event) {
        $this->sendForgottenPasswordEmail($event->getUser(), $event->getToken());
    }

    private function generateResetToken() {
        $length = 50;
        $token = bin2hex(random_bytes($length));
        return$token;
    }

    /**
     * <p>Checks to see if <i>$number</i> is a valid phone number or not.</p><br />
     * @param string $number <p>The value to check whether it is a valid phone number or not.</p><br />
     * @return boolean <i>true</i> if <i>$number</i> is a valid phone number otherwise it returns <i>false</i>.
     */
    public static function isValidPhoneNumber($number) {
        return preg_match("/^\+?[0-9]{8,15}$/", $number) > 0 ? true : false;
    }

    public function isValidEmail($recipient) {
        return filter_var($recipient, FILTER_VALIDATE_EMAIL);
    }

    private function sendSMSWithHubtel($recipientNumber, $message) {
        if (self::isValidPhoneNumber($recipientNumber)) {
            $auth = new BasicAuth($this->apiKey, $this->apiSecret);
            $apiHost = new ApiHost($auth);
            $messagingApi = new MessagingApi($apiHost);
            $retVal = [];
            try {
                $messageResponse = $messagingApi->sendQuickMessage('BuildersHub', $recipientNumber, $message);
                if ($messageResponse instanceof MessageResponse || $messageResponse instanceof HttpResponse) {
                    $retVal['status'] = $messageResponse->getStatus();
                }
            } catch (Exception $ex) {
                $retVal['error'] = $ex->getMessage();
            }
            return $retVal;
        }
    }

    public function sendSMSWithTwilio($recipientNumber, $message) {
        if (self::isValidPhoneNumber($recipientNumber)) {
            $msg = $this->twilio->messages->create(
                    $recipientNumber, // Text any number
                    array(
                'from' => Constants::TWILIO_SMS_NUMBER, // From a Twilio number in your account
                'body' => $message
            ));
            //get an instance of \Service_Twilio
            //$otherInstance = $twilio->createInstance('BBBB', 'CCCCC');
            return new Response($msg->sid);
        }
    }

}
