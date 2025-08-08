<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * If Token is Expired
     *
     * @return void
     */
    public function tokenIsExpired($googleService, $scope = 'Blogger')
    {
        if (!$credential = $googleService->getCredentails($scope)) return false;

        $data = json_decode($credential->token);
        if (isset($data->expires_in)) {
            $updatedTime = new Carbon($credential->updated_at);
            $currentTime = Carbon::now();
            $expirationDateTime = $updatedTime->addSeconds($data->expires_in);
            if ($currentTime->greaterThanOrEqualTo($expirationDateTime)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get Site Base URL
     *
     * @return void
     */
    public function getSiteBaseUrl()
    {
        $siteSetting = SiteSetting::first();

        if ($siteSetting) return $siteSetting->url;
    }
}
