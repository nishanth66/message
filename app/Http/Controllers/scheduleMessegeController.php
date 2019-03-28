<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\usermessage;
use App\Models\packages;
use Illuminate\Support\Facades\Mail;
use function Sodium\crypto_aead_aes256gcm_decrypt;
use function Sodium\crypto_aead_aes256gcm_encrypt;

class scheduleMessegeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function reminder()
    {
        $users = users::where('status','user')->where('type','!=','disabled')->get();
        foreach ($users as $user)
        {
            $data = array(
                'name' => $user->name,
                'id' => $user->id,
                'email' => $user->email
            );
            $package = packages::whereId((int)$user->package)->first();
            $limitMsg = $package->no_of_limit_messages;
            $available_msg = (int)$user->available_msg;
            $now = time();

            if ($available_msg != 0)
            {
                $msgId = $user->msgid;

                if (usermessage::where('userid',$user->id)->where('msgid',$msgId)->exists() == 0)
                {
                    continue;
                }
                if (DB::table('default_reminder')->exists())
                {
                    $defaultMessage = DB::table('default_reminder')->first();
                }
                else
                {
                    $defaultMessage = "";
                }

                $userMsg = usermessage::where('userid',$user->id)->where('msgid',$msgId)->first();
                $msg = $userMsg->message;
                $emails = $userMsg->emails;
                $encrypted = hex2bin($msg);
                $encrypted2 = hex2bin($emails);
                openssl_private_decrypt($encrypted, $decrypted, $user->private_key);
                openssl_private_decrypt($encrypted2, $decrypted2, $user->private_key);
                $data['msg'] = $decrypted;
                $emails = $decrypted2;
                $msgUpdate['disabled'] = 1;


                $scheduleDay = $userMsg->day;
                $remember_to_login = (int)$user->days_remember_to_login;

                $last_login = $user->lastUpdated;
                $datediff = $now - $last_login;
                $days = $datediff / (60 * 60 * 24);
                $days = round($days);

                if (($user->lastreminder == '' || empty($user->lastreminder) || $user->lastreminder == null)) {
                    if ($days >= $scheduleDay)
//                    if ($days > 0)
                    {
                        $this->sendSchedule($user,$userMsg,$available_msg,$msgId,$now,$data,$emails);
                    }
                    elseif ($days >= $remember_to_login)
//                    elseif ($days > 0)
                    {
                        $this->sendReminder($user,$defaultMessage,$now,$data);
                    }
                }
                else
                {
                    if ($user->schedule_reminder == '' || $user->schedule_reminder == null || empty($user->schedule_reminder))
                    {
                        $last_login = $user->lastreminder;
                        $datediff = $now - $last_login;
                        $days = $datediff / (60 * 60 * 24);
                        $days = round($days);
                        if ($days >= $remember_to_login)
//                        if ($days > 0)
                        {
                            $this->sendReminder($user,$defaultMessage,$now,$data);
                        }
                    }
                    else
                    {
                        $last_login = $user->schedule_reminder;
                        $datediff = $now - $last_login;
                        $days = $datediff / (60 * 60 * 24);
                        $days = round($days);
                        if ($days >= $scheduleDay)
//                        if ($days > 0)
                        {
                            $this->sendSchedule($user,$userMsg,$available_msg,$msgId,$now,$data,$emails);
                        }
                        else
                        {
                            $last_login = $user->lastreminder;
                            $datediff = $now - $last_login;
                            $days = $datediff / (60 * 60 * 24);
                            $days = round($days);
                            if ($days >= $remember_to_login)
//                            if ($days > 0)
                            {
                                $dataReturn=$this->sendReminder($user,$defaultMessage,$now,$data);
                                return $dataReturn;
                            }
                        }
                    }
                }
            }
            else
            {
                $disable = DB::table('servicedisable')->first();
                $disableTime = (int)$disable->finish;
                $lastReminder = $user->schedule_reminder;
                $datediff = $now - $lastReminder;
                $days = $datediff / (60 * 60 * 24);
                $days = round($days);
                if ($available_msg == 0 && $days > $disableTime)
//                if ($available_msg == 0 && $days > 0)
                {
                    $input11['type'] = "disabled";
                    $input11['reason'] = "Finish of maximum Schedule Messages";
                    users::whereId($user->id)->update($input11);
                }
            }



        }
    }

    function sendReminder($user,$defaultMessage,$now,$data)
    {
        if ($defaultMessage!="")
        {
            $data['msg'] = $defaultMessage->message;
        }
        else
        {
            $data['msg'] = "Hey did You Forget to Login to Messenger?";
        }
        $data['msgType'] = 1;
        $data['email'] = $user->email;
        Mail::send('emails.welcome', ['data' => $data], function ($message) use ($data)
        {
            $message->from('message@kpfiles.com', "Messenger");
            $message->subject("Reminder to Login");
            $message->to($data['email']);
        });
        users::whereId($user->id)->update(['lastreminder'=>$now]);
    }
    function sendSchedule($user,$userMsg,$available_msg,$msgId,$now,$data,$emails)
    {
        $data['msgType'] = 0;
        $data['email'] = $user->email;
        Mail::send('emails.welcome', ['data' => $data], function ($message) use ($data) {
            $message->from('message@kpfiles.com', "Messenger");
            $message->subject("Scheduled Message");
            $message->to($data['email']);
        });
        if ($emails != "") {
            $emails = explode(',', $emails);
            foreach ($emails as $email) {
                $data['email'] = str_replace(' ', '', $email);
                Mail::send('emails.welcome', ['data' => $data], function ($message) use ($data) {
                    $message->from('message@kpfiles.com', "Messenger");
                    $message->subject("Scheduled Message");
                    $message->to($data['email']);
                });
            }
        }
        usermessage::whereId($userMsg->id)->update(['disabled'=>1]);
        $available_msg--;
        $msgId++;
        $input1['schedule_reminder'] = $now;
        $input1['lastreminder'] = $now;
        $input1['available_msg'] = (int)$available_msg;
        $input1['msgid'] = (int)$msgId;
        users::whereId($user->id)->update($input1);
    }




    public function disableUser()
    {
        $users = users::where('status', 'user')->get();
        foreach ($users as $user)
        {
            $disable = DB::table('servicedisable')->first();
            $now = time();
            $your_day = $user->package_expire;
            $datediff = $now - $your_day;
            $days = $datediff / (60 * 60 * 24);
//             $days = round($days);
            if ($days > (int)$disable->expire)
            {
                $input111['type'] = "disabled";
                $input111['reason'] = "Didn't renew within the time period";
                users::whereId($user->id)->update($input111);
            }
        }
    }
}
