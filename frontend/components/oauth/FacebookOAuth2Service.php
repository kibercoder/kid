<?php

namespace frontend\components\oauth;

class FacebookOAuth2Service extends \nodge\eauth\services\FacebookOAuth2Service
{

    protected function fetchAttributes()
    {
        $this->attributes = $this->makeSignedRequest('me', [
            'query' => [
                'fields' => join(',', [
                    'id',
                    'name',
                    'link',
                    'email',
                    'verified',
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'hometown',
                    'location',
                    'locale',
                    'timezone',
                    'updated_time',
                ])
            ]
        ]);

        $this->attributes['avatar'] = $this->baseApiUrl.$this->getId().'/picture?width=100&height=100';

        return true;
    }


}