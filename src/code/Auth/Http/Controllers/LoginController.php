<?php

namespace Code\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Code\User\Model\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect(route('login'));
    }

    /**
     * Redirect the user to the social provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from social provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            if ($provider === "twitter") {

                $dbUser = User::where('twitter_id', $user->id)->first();

                if (!count($dbUser) || !isset($dbUser->email)) {
                    /**
                     * If we don't user's email address we must force user to 
                     * provide us email address. In order to do that we should 
                     * maintain user records we received from twitter and redirect
                     * him to email form page.
                     */
                    session()->put('twitter_user', $user);
                    return redirect(route('twitter.email'));
                }
                /**
                 * Since we are going to get email from twitter
                 * response we are updating the twitter response
                 * with our database record.
                 */
                $user->email = $dbUser->email;
            } else {
                $dbUser = $this->findOrCreateUser($user);
            }


            $dbUser = $this->updateRecords($dbUser, $user, $provider);
            
            auth()->login($dbUser, true);

            return redirect()->to('/');

        } catch (Exception $e) {
            return Redirect::to('/auth/login');
        }  
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $socialLiteUser
     *
     * @return User
     */
    private function findOrCreateUser($socialLiteUser)
    {
        $user = User::where('email', $socialLiteUser->email)->first();

        if (!$user) {
            $user = new User;
        }

        return $user;
    }

    /**
     * Updates the records
     *
     * @param      \Code\User\Model\User  $user            The user
     * @param      Socialite\User  $socialLiteUser  The social lite user
     * @param      string  $key             The key
     *
     * @return     \Code\User\Model\User
     */
    private function updateRecords($user, $socialLiteUser, $key)
    {
        $user->email          = (strlen($socialLiteUser->email)) ? $socialLiteUser->email : $user->email;
        $user->{$key . '_id'} = $socialLiteUser->id;
        $user->name           = $socialLiteUser->name;
        $user->image          = $socialLiteUser->avatar;

        $user->save();

        return $user;
    }

    /**
     * Renders the form to get email from twitter user
     * 
     * @return \Illuminate\View\View
     */
    public function getEmailFromTwitter()
    {
        return view('auth.twitter');
    }

    /**
     * Posts an email from twitter.
     *
     * @return    \Illuminate\Http\RedirectResponse
     */
    public function postEmailFromTwitter()
    {
        $this->validate(request(), [
            'email' => 'required|unique:users'
        ]);

        if (!session()->has('twitter_user')) {
            error('Something went wrong. Please try logging again');
            return redirect(route('login'));
        }

        $socialLiteUser        = session('twitter_user');
        $socialLiteUser->email = request('email');

        $dbUser = $this->findOrCreateUser($socialLiteUser);
 
        $dbUser = $this->updateRecords($dbUser, $socialLiteUser, 'twitter');
            
        auth()->login($dbUser, true);
        
        return redirect()->to('/');
    }
}
