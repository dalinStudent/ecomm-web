<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function api_post($url, $data)
    {
        try {
            $authorize = $this->getAuthorize();
            $locale = app()->getLocale() ?? config('app.fallback_locale');
            $headers = array('Accept' => 'application/json', 'Authorization' => $authorize->token);
            $api = new Client(['base_uri' => env('API_URL'), 'http_errors' => false, 'headers' => $headers]);

            if ($this->auth) {
                $headers = array('Auth' => $this->auth->access_token,
                    'Accept' => 'application/json',
                    'Authorization' => $authorize->token,
                    'Locale' => $locale,
                );
                $api = new Client(['base_uri' => env('API_URL'), 'http_errors' => false, 'headers' => $headers]);
            }

            $response = $api->request('POST', $url, [
                'json' => $data,
            ]);

            $data = json_decode($response->getBody());

            if ($response->getStatusCode() == 500) {
                return (object) ['success' => false, 'message' => $data->message];
            } elseif ($response->getStatusCode() == 200) {
                return $data;
            } elseif ($response->getStatusCode() == 401 || $response->getStatusCode() == 402) {
                self::clearAuth();

                return Redirect::away('/login')->send();
            } elseif ($response->getStatusCode() == 403) {
                abort(403);
            } else {
                return json_decode($response->getBody());
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
