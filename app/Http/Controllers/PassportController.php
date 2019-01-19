<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;


use App\Auth\Models\ApiUser;
use Auth\Services\ApiUserService;
use GuzzleHttp\Client;
use Auth\Pojos\ApiUserPojo;


class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    protected $apiUserService;
    
    public function __construct(ApiUserService $apiUserService)
    {
        $this->apiUserService = $apiUserService;
    }
    
    /**
     * Handles Api User Registration
     * 
     * @param Request $request
     * @return @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:api_users',
            'password' => 'required|min:8',
        ]);
        
        $apiUserPojo = new ApiUserPojo();
        $apiUserPojo->email = $request->email;
        $apiUserPojo->password = $request->password;
        $apiUserPojo->name = $request->name;
        
        $user = $this->apiUserService->registerUser($apiUserPojo);
        return response()->api($user);
    }
    
    public function assignTokenScope(Request $request){
        $this->validate($request, [
            'email' => 'required|email'
            
        ]);
        $user_id = $request->input('email');
        
        $scopes = $request->input('scopes');
        
        $user = $this->apiUserService->assignTokenScope($user_id, $scopes);
        
        return response()->api($user);
    }
    
    /**
     * Handles Access Token Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccessToken(Request $request)
    {
        $token =  $this->apiUserService->getAccessToken($request->email, $request->password);
        return response()->api($token);
    }
    
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        //return response()->json(['user' => auth()->user()], 200);
        return response()->api(['user' => auth()->user()]);
    }
    
    public function getOAuthDetails()
    {
        
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env("BASE_URL"),
        ]);
        
        $response = $client->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => '0GJtIB4O5j9B4ihIa5y4CrD6yb1iMTFwWrqAij7H',
                'redirect_uri' => env("BASE_URL") . '/callback',
                //'username' => 'sajid@test.com',
                //'password' => 'my_password',
                'scope' => '*',
            ],
        ]);
        
        //$instance = Route::dispatch($tokenRequest);
        //return json_decode((string) $response->getBody(), true);
        return response()->api($response->getBody());
    }
    
    function tokenRequest(Request $request)
    {
        
        $request->request->add([
            "grant_type" => "password",
            //"username" => $request->username,
            //"password" => $request->password,
            "client_id"     => "2",
            "client_secret" => "0GJtIB4O5j9B4ihIa5y4CrD6yb1iMTFwWrqAij7H",
        ]);
        
        $tokenRequest = $request->create(
            env('BASE_URL').'/oauth/token',
            'post'
            );
        
        //$instance = Route::dispatch($tokenRequest);
        return response()->api(['token' => $tokenRequest]);
        //return json_decode($tokenRequest);
        
    }
    
}
