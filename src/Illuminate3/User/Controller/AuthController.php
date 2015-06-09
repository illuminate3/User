<?php

namespace Illuminate3\User\Controller;

use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;

use App, View, Sentry, Input, Redirect;

class AuthController extends \BaseController
{
    public function login()
    {
        $fb = App::make('formbuilder');
        $fb->route('user.auth');
        $fb->defaults(Input::all());
        
        $fb->text('email')->label('E-mail');
        $fb->password('password')->label('Password');
        
        $form = $fb->build();
        
        return View::make('user::login', compact('form'));
    }

    public function auth()
    {
        try
        {
            // Try to authenticate the user
            $user = Sentry::authenticate(Input::only(array('email', 'password')), false);
                        
            // Log the user in
            Sentry::login($user, false);
            
            // Redirect to dashboard
            return Redirect::route('admin.index');
            
        }
        catch (LoginRequiredException $e)
        {
            $errors['email'] = 'Login field is required.';
        }
        catch (PasswordRequiredException $e)
        {
            $errors['password'] = 'Password field is required.';
        }
        catch (WrongPasswordException $e)
        {
            $errors['password'] = 'Wrong password, try again.';
        }
        catch (UserNotFoundException $e)
        {
            $errors['email'] = 'User was not found.';
        }
        catch (UserNotActivatedException $e)
        {
            $errors['email'] = 'User is not activated.';
        }

        // The following is only required if throttle is enabled
        catch (UserSuspendedException $e)
        {
            $errors['email'] = 'User is suspended.';
        }
        catch (UserBannedException $e)
        {
            $errors['email'] = 'User is banned.';
        }      
                
        // There are some errors at this point.
        // Redirect to the login page and display the errors
        return Redirect::route('user.login')->withErrors($errors)->withInput();
    }
    
    public function logout()
    {
        // Logs the user out
        Sentry::logout();
        
        return Redirect::home();
    }
    
    public function status()
    {
        if(!Sentry::check()) {
            return;
        }
        
        return View::make('user::status', array(
            'user' => Sentry::getUser(),
        ));
    }

}