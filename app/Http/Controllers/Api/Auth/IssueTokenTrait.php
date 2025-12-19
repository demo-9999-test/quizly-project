<?php 

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

public function issueToken(Request $request, $grantType, $scope = ""){
    $params = [
        'grant_type' => $grantType,
        'client_id' => $this->client->id,
        'client_secret' => $this->client->secret,
        'scope' => $scope
    ];
    
    // Check if this is a mobile or email authentication
    if ($request->has('mobile')) {
        $params['username'] = $request->mobile;
    } else {
        $params['username'] = $request->email;
    }
    
    // Make sure to include the password
    if ($request->has('password')) {
        $params['password'] = $request->password;
    }
    
    $request->request->add($params);
    $proxy = Request::create('oauth/token', 'POST');
    
    // Transfer all the parameters from the original request
    $proxy->request->add($request->all());
    
    return Route::dispatch($proxy);
}

}