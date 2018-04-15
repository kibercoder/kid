<?php

namespace frontend\components\oauth;

class VKontakteOAuth2Service extends \nodge\eauth\services\VKontakteOAuth2Service
{

    const SCOPE_FRIENDS = 'friends';
    const API_VERSION = '5.57';

    protected $name = 'vkontakte';
    protected $title = 'VK.com';
    protected $type = 'OAuth2';
    protected $jsArguments = ['popup' => ['width' => 585, 'height' => 350]];

    protected $scopes = [self::SCOPE_FRIENDS];
    protected $providerOptions = [
        'authorize' => 'http://api.vk.com/oauth/authorize',
        'access_token' => 'https://api.vk.com/oauth/access_token',
    ];
    protected $baseApiUrl = 'https://api.vk.com/method/';

  	protected function fetchAttributes()
    {
        /*$tokenData = $this->getAccessTokenData();
        $info = $this->makeSignedRequest('users.get', [
            'query' => [
                'uids' => $tokenData['params']['user_id'],
                'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_50, photo_big, photo_rec',
            ],
        ]);*/



        $tokenData = $this->getAccessTokenData();
        $info = $this->makeSignedRequest('users.get.json', [
            'query' => [
                'uids' => $tokenData['params']['user_id'],
                //'fields' => '', // uid, first_name and last_name is always available
                'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
                'v' => self::API_VERSION,
            ],
        ]);

/*
Array ( [id] => 80619638 [first_name] => Коля [last_name] => Валуев [sex] => 2 [nickname] => [bdate] => 1.1.1987 [city] => Array ( [id] => 123 [title] => Самара ) [country] => Array ( [id] => 1 [title] => Россия ) [timezone] => 4 [photo] => https://pp.userapi.com/c638531/v638531638/9d31/9dXp3meGAR8.jpg [photo_rec] => https://pp.userapi.com/c638531/v638531638/9d31/9dXp3meGAR8.jpg [photo_medium] => https://pp.userapi.com/c638531/v638531638/9d30/Tg_Ci0VnIC4.jpg [photo_big] => https://pp.userapi.com/c638531/v638531638/9d2e/QHAPIly1ic8.jpg )
*/
        $info = $info['response'][0];

        $this->attributes = $info;
        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = $info['first_name'] . ' ' . $info['last_name'];
        $this->attributes['first_name'] = $info['first_name'];

        $this->attributes['last_name'] = $info['last_name'];

        $this->attributes['url'] = 'http://vk.com/id' . $info['id'];

        if (!empty($info['nickname'])) {
            $this->attributes['username'] = $info['nickname'];
        } else {
            $this->attributes['username'] = 'id' . $info['id'];
        }

        $this->attributes['gender'] = $info['sex'] == 1 ? 'F' : 'M';

        $this->attributes['birthdate'] = strtotime($info['bdate']);

        $this->attributes['city'] = (strlen($info['city']['title'])>0) ? $info['city']['title'] : $info['city']['id'];


        if (!empty($info['timezone'])) {
            $this->attributes['timezone'] = timezone_name_from_abbr('', $info['timezone'] * 3600, date('I'));
        }

        if (!empty($info['photo_big'])) {

            $this->attributes['avatar'] = $info['photo_big'];

        } else if (!empty($info['photo_50'])) {
            $this->attributes['avatar'] = $info['photo_50'];
        }

        return true;
    }

}