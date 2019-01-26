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
    
    /**
     * 
     * @var ApiUserService
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
    
}
