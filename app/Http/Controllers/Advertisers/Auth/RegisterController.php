<?php

namespace App\Http\Controllers\Advertisers\Auth;
use App\Models\AdvertiserCompany;
use App\Models\Country;
use App\Models\Trans\AdvertiserCompanyTrans;
use App\Repositories\RegisterAdvertisersUserRepository;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Twilio\Rest\Client;
use App\Http\Requests\UserRegisterRequest;
use App\Contracts\UserContract;
use App\Contracts\AdvertiserCompanyContract;
use App\Mail\RegisterEmail;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    /**
     * Object of AdvertiserCompanyContract class
     *
     * @var advertCompanyRepo
     */
    private $advertCompanyRepo;

    protected $register_advert_user_rep;


   // use RegistersUsers;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/advertiser/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegisterAdvertisersUserRepository $register_advert_user_rep, UserContract $userRepo, AdvertiserCompanyContract $advertCompanyRepo)
    {
     //   $this->middleware('guest', ['except'=>['confirmation']]);

        $this->register_advert_user_rep = $register_advert_user_rep;
        $this->userRepo = $userRepo;
        $this->advertCompanyRepo = $advertCompanyRepo;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorByEmail(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|numeric',
            'phone_code' => 'required',
            'title' => 'required',
            'token' => str_random(25),
        ]);
    }

    protected function validatorByPhone(array $data)
    {
        return Validator::make($data, [
            'phone' => 'required|numeric',
            'phone_code' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createByEmail(array $data)
    {
       $result = $this->register_advert_user_rep->createByEmail($data);

       return $result;
    }

    protected function createByPhone(array $data)
    {
        $result = $this->register_advert_user_rep->createByPhone($data);
        return $result;
    }


   public function registerByEmail(UserRegisterRequest $request)
    {
        // $input = $request->all();
        // $validator = $this->validatorByEmail($input);


        // if($validator->passes()){
        //     $data = $this->createByEmail($input)->toArray();

        //     $user = User::find($data['id']);

        //     $user->save();

        //     Mail::send('advertisers.includes.email_confirmation_text', ['data' => $data], function ($message) use ($data) {
        //         $sender_email = 'admin@tablepm.loc';
        //         $message->to($data['email'])
        //             ->subject('Registration Confirmation');
        //     });
        //     return redirect()->route('advertiser.register.showRegisterPreConfirmMessage');

        // }
        // return redirect()->back()->with(['fail' => $validator->errors()]);
        $data = $request->data($request);
        $user = $this->userRepo->addUser($data);
        $slug = str_random(10);
        $advertCompanyCreateData = [
            'user_id' => $user->id,
            'slug' =>$slug
        ];
        $advertCompany = $this->advertCompanyRepo->createAdvertCompany($advertCompanyCreateData);
        $advertCompanyTransData = [
            'title' => $data['company_name'],
            'slug_article' => $slug,
            'lang' => \App::getLocale()
        ];
        $advertCompanyTrans = $this->advertCompanyRepo->createAdvertCompanyTrans($advertCompanyTransData);
        Mail::to($user)->send(new RegisterEmail($data));
        return view('advertisers.auth.email.registerPreConfirmMessage', ['email' => $user->email]);
    }

    public function showRegisterPreConfirmMessage($email)
    {
        return view('advertisers.auth.email.registerPreConfirmMessage', ['email' => $email]);
    }

    public function registerByPhone(Request $request)
    {
        $input = $request->all();
        $validator = $this->validatorByPhone($input);


        if($validator->passes()){
            $data = $this->createByPhone($input)->toArray();
            $data['token'] = str_random(25);

            $user = User::find($data['id']);
            $user->token = $data['token'];
            $user->save();

// Your Account SID and Auth Token from twilio.com/console
            $account_sid = env('TWILIO_ACCOUNT_SID');
            $auth_token = env('TWILIO_AUTH_TOKEN');
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
            $to = '+'. $request->phone_code . $request->phone;


            $twilio_number = env('TWILIO_NUMBER');

            $client = new Client($account_sid, $auth_token);
            $message = $client->messages->create(
            // Where to send a text message (your cell phone?)
                $to,
                //'+37455666082',
                array(
                    'from' => $twilio_number,
                    'body' => 'I sent this message in under 10 minutes!'
                )
            );

            
            return redirect()->back()->with(['success' => 'Confirmation E-mail has been send. Please check your E-main']);

        }
        return redirect()->back()->with(['fail' => $validator->errors()]);

    }


    public function phoneVerifyCodeForm()
    {
        
    }

    public function confirmation($token)
    {
        $user = User::where(['token' => $token])->first();
        if(!is_null($user)){
            $user->token = '';
            $user->confirmed = 1;
            $user->save();

            // return redirect(route('advertisIndex'))->with(['success' => 'Your activation is completed']);
            return view('advertisers.auth.email.register_confirmation')->with(['status' => 'success']);
        }
        return view('advertisers.auth.email.register_confirmation')->with(['status' => 'error']);
    }


    public function redirectPath()
    {

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    public function showRegistrationFormEmail()
    {
        $countries = Country::all();
        return view('advertisers.auth.email.register')->with(['countries' => $countries]);
    }

    public function showRegistrationFormPhone()
    {
        $countries = Country::all();
        return view('advertisers.auth.phone.register')->with(['countries' => $countries]);
    }



    protected function registered(Request $request, $user)
    {


        return redirect('advertisers.login')->with(['status' => 'Confirmation email has been send. Please check your E-mail']);
    }


    protected function guard()
    {
        return Auth::guard();
    }
}
