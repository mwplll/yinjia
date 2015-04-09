<?php

class userLogoutApiAction extends baseAction
{
    public function execute()
    {
        $userObj = new LibUser();
        $userObj->logout();

        $tplData['errorCode'] = SUCCESS;
        $this->echo_json($tplData);
    }
}
