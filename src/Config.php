<?php

namespace YuanBen;

class Config
{
    const USER_MEDIA = 'Media';
    const USER_PLATFORM = 'Platform';

    protected $token;
    protected $userType;

    public function __construct($token, $userType = 'Media')
    {
        $this->token = $token;
        $this->setUserType($userType);
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function userCanBe($userType)
    {
        $allows = [self::USER_MEDIA, self::USER_PLATFORM];

        return array_search($userType, $allows) !== false;
    }

    public function setUserType($userType)
    {
         $this->userCanBe($userType)
            ? $this->userType = $userType
            : $this->userType = self::USER_MEDIA;

        return $this;
    }

    public function getPrefix()
    {
        return strtolower($this->userType).'/';
    }
}
