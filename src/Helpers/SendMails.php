<?php

namespace Acolyte\ErrorLog\Helpers;
use Illuminate\Support\Facades\Mail;
use Acolyte\ErrorLog\Models\ErrorLog;

/**
 * Class SendMails, this class is to send various types of mails
 *
 * @package App
 */
class SendMails
{

    public static function sendMail(array $data, $view)
    {
        if(isset($data['email'])) {
            $to_email = $data['email'];
        }
        else{
            $to_email = SendMails::config('errorlog.MAIL_FROM_ADDRESS');
        }
        $from_email = SendMails::config('errorlog.MAIL_FROM_ADDRESS');
        $from_name = SendMails::config('errorlog.MAIL_FROM_NAME');
        if(isset($data['from_email'])){
            $from_email = $data['from_email'];
        }
        if(isset($data['from_name'])){
            $from_name = $data['from_name'];
        }
        if(isset($data['subject'])) {
            $subject = $data['subject'];
        }
        else{
            $subject = "Welcome To ".SendMails::config('errorlog.MAIL_FROM_NAME');
        }
        Mail::send($view, $data, function ($message) use ($to_email,$from_email,$from_name,$subject) {
            $message->from($from_email, $from_name);
            $message->to($to_email)->subject($subject);
        });

    }

    public static function sendErrorMail($message, $view=NULL, $controller, $method, $line_number=NULL, $file_path=NULL, $object=NULL,$type=NULL, $argument=NULL, $email=NULL)
    {
        
        $data = array(
            'exception_message' => $message,
            'method_name'    	=> $method,
            'line_number'      	=> $line_number,
            'file_path'			=> $file_path,
            'class' 		 	=> $controller,
            'object' 		 	=> $object,
            'type' 		 		=> $type,
            'argument' 		 	=> $argument,
            'email' 		 	=> $email,
            'domain' 		 	=> isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'',
            'client' 		 	=> config('errorlog.MAIL_FROM_NAME'),
            'subject' 		 	=> 'Error Notification'
        );
        $view = 'acolyte.errorlog.emails.error_exception_email';
        $email = config('errorlog.MAIL_TO_ADDRESS');

        if(config('errorlog.MAIL_CC_ADDRESS')) {
            $email = array($email, config('errorlog.MAIL_CC_ADDRESS'));
        }
        $subject = $data['subject'];

        Mail::send($view, $data, function ($message) use ($email, $subject) {
            $message->from(config('errorlog.MAIL_FROM_ADDRESS'), config('errorlog.MAIL_FROM_NAME'));

            $message->to($email)->subject($subject);
        });

        /*Save error to database*/
        $screenshot = '';
        $prefix = '';
        $domain = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';
        $page_url = $domain. isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        $error = self::saveErrorLog($method,$line_number,$file_path,$message,$object,$type,$screenshot,$page_url,$argument,$prefix,$domain);
        return $error;
    }

    public static function saveErrorLog($method,$line_number,$file_path,$message,$object,$type,$screenshot,$page_url,$argument,$prefix,$domain){
        /*Save error to database*/
        try{
            $errorLog = NEW ErrorLog();
            $errorLog->method_name = $method;
            $errorLog->line_number = $line_number;
            $errorLog->file_path = $file_path;
            $errorLog->exception_message = $message;
            $errorLog->object = $object;
            $errorLog->type = $type;
            $errorLog->screenshot = $screenshot;
            $errorLog->page_url = $page_url;
            $errorLog->arguments = $argument;
            $errorLog->prefix = $prefix;
            $errorLog->domain = $domain;
            $errorLog->save();
            return $errorLog->id;
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
