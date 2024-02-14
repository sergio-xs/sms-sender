<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'login' => [
        'message' => 'Please sign-in to your account!',
        'welcome' => 'Welcome to',
        'email' => 'Email',
        'password' => 'Password',
        'forgot_password' => 'Forgot Password?',
        'remember_me' => 'Remember Me',
        'button' => 'Sign in',
    ],

    'forgot_password' => [
        'title' => 'Forgot Password?',
        'message' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'email' => 'Email',
        'button' => 'Email Password Reset Link',
        'login' => 'Back to login',
    ],

    'reset_password' => [
        'title' => 'Reset Password',
        'message' => 'Your new password must be different from previously used passwords',
        'new_password' => 'New Password',
        'password_confirmation' => 'Confirm Password',
        'button' => 'Reset Password',
        'login' => 'Back to login',
    ],

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'logged_in' => 'User logged in successfully',

];
