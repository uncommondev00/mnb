<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Utils\BusinessUtil;

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
     * All Utils instance.
     *
     */
    protected $businessUtil;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BusinessUtil $businessUtil)
    {
        $this->middleware('guest')->except('logout');
        $this->businessUtil = $businessUtil;
    }

    /**
     * Change authentication from email to username
     *
     * @return void
     */
    public function username()
    {
        return 'username';
    }

    public function logout()
    {
        request()->session()->flush();
        \Auth::logout();
        return redirect('/login');
    }

    /**
     * The user has been authenticated.
     * Check if the business is active or not.
     *
     * Check if the user has a permission to the provider
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {   

         if(config('app.env') == 'live'){

         }else{
        $permission_1 = config('app.permit_1');

        $permission_2 = config('app.permit_2');

        $permission_3 = config('app.permit_3');

        $permission_4 = config('app.permit_4');

        $permission_5 = config('app.permit_5');



        $permission_Address=$_SERVER['REMOTE_ADDR'];

        $main_permission="";

        $arp=`arp -a $permission_Address`;
        $lines=explode("\n", $arp);

        foreach($lines as $line)
        {
            $cols=preg_split('/\s+/', trim($line));
                if ($cols[0]==$permission_Address)
                    {
                       $main_permission=$cols[1]; 
                    }

        }
        if($main_permission == $permission_2 || $main_permission == $permission_1 || $main_permission == "" || $main_permission == $permission_3 || $main_permission == $permission_4 || $main_permission == $permission_5)   {
           
        }else{
             request()->session()->flush();
            \Auth::logout();
            return redirect('invalid_mac');
        }
        
        }




        if (!$user->business->is_active) {
            \Auth::logout();
            return redirect('/login')
              ->with(
                  'status',
                  ['success' => 0, 'msg' => __('lang_v1.business_inactive')]
              );
        } elseif ($user->status != 'active') {
            \Auth::logout();
            return redirect('/login')
              ->with(
                  'status',
                  ['success' => 0, 'msg' => __('lang_v1.user_inactive')]
              );
        }
    }

    protected function redirectTo()
    {
        $user = \Auth::user();
        if (!$user->can('dashboard.data') && $user->can('sell.create')) {
            return '/pos/create';
        }

        return '/home';
    }
}
