<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;


class MyResetPasswordNotification extends \Illuminate\Auth\Notifications\ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = (new MailMessage())
            ->view('emails.email',
                [
                    'title' => 'Reset Password',
                    'content' => 'You are receiving this email because we received a password reset request for 
                    your account. Click the button below to reset your password:']
            )
            ->from(env('MAIL_USERNAME'), 'MY EXPO')
            ->subject('Reset Password')
            ->action('Reset Password', url('en/password/reset', $this->token));
        if (app()->isLocale('ar')) {
            $email = (new MailMessage())
                ->view('emails.email',
                    [
                        'title' => 'استعادة كلمة المرور',
                        'content' => 'لقد تم ارسال رابط اعادة تعيين كلمة المرور بناء على طلبك يرجى النقر على الزر بالاسفل لتعيين كلمة مرور جديدة',
                    ]
                )
                ->from(env('MAIL_USERNAME'), 'MY EXPO')
                ->subject('تعيين كلمة مرور جديدة')
                ->action('تعيين كلمة مرور جديدة', url( 'ar/password/reset', $this->token));
        }
        return $email;
    }
}