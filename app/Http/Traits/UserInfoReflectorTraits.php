<?php
/**
 * Created by PhpStorm.
 * User: c2
 * Date: 7/6/18
 * Time: 7:44 PM
 */

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait UserInfoReflectorTraits
{


    /**
     * Display a listing of the users given their chunck of ids.
     *
     * @return Array|\Illuminate\Support\Collection
     */
    public function listUsersInfo(array $userIds, $userId = null)
    {
        $fetchUsersInfos = DB::table('users')
            ->join('user_basic_profiles', 'users.id', '=', 'user_basic_profiles.user_id')
            ->select('users.id',
                'users.full_name',
                'users.username',
                'users.default_profile',
                'users.default_profile_image',
                'user_basic_profiles.gender',
                'user_basic_profiles.profile_photo_url',
                'user_basic_profiles.profile_cover_image_url',
                'user_basic_profiles.profile_background_color',
                'user_basic_profiles.profile_preferred_color',
                'user_basic_profiles.profile_background_image_url',
                'user_basic_profiles.profile_background_tile',
                'user_basic_profiles.about_me',
                'user_basic_profiles.birthday',
                'user_basic_profiles.screen_status_code',
                'user_basic_profiles.screen_status_custom',
                'users.created_at'
            )
            ->whereIn('users.id', $userIds);
        return $fetchUsersInfos;
    }

    private function showScreenStatus($code = null, $custom = null) {

        if (!is_null($custom)){
            return $custom;
        }
        elseif (!is_null($code)) {
        $screenStatus = DB::table('user_basic_profiles')
            ->join('screen_statuses', 'user_basic_profiles.screen_status_code', '=', 'screen_statuses.screen_status_code')
            ->select('screen_statuses.screen_status')
            ->where('user_basic_profiles.screen_status_code', '=', $code)
            ->get()->first();

            return $screenStatus->screen_status;
        }
        else {
            return null;
        }
    }

    private function amFollowing($authenticatedUserId = null, $otherUserId = null)
    {
        $checkMyFollowingStatus = DB::table('follow_lists')
            ->where(function ($query) use ($authenticatedUserId, $otherUserId){
                $query->where('follow_from_id', '=', $authenticatedUserId)
                    ->where('follow_to_id', '=', $otherUserId)
                    ->where('follow_from_status', '=', 'follow');
            })

            ->orWhere(function ($query) use ($authenticatedUserId, $otherUserId){
                $query->where('follow_to_id', '=', $authenticatedUserId)
                    ->where('follow_from_id', '=', $otherUserId)
                    ->where('follow_to_status', '=', 'follow');

            })->get()->first();

        if(!is_null($checkMyFollowingStatus))
        {
            return true;
        }
        else return false;
    }



    private function isFollower($authenticatedUserId = null, $otherUserId = null)
    {
        $checkMyFollowingStatus = DB::table('follow_lists')
            ->where(function ($query) use ($authenticatedUserId, $otherUserId){
                $query->where('follow_from_id', '=', $authenticatedUserId)
                    ->where('follow_to_id', '=', $otherUserId)
                    ->where('follow_to_status', '=', 'follow');
            })

            ->orWhere(function ($query) use ($authenticatedUserId, $otherUserId){
                $query->where('follow_to_id', '=', $authenticatedUserId)
                    ->where('follow_from_id', '=', $otherUserId)
                    ->where('follow_from_status', '=', 'follow');

            })->get()->first();

        if(!is_null($checkMyFollowingStatus))
        {
            return true;
        }
        else return false;
    }



}