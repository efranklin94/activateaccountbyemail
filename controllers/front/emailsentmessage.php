<?php

class activateaccountbyemailemailsentmessageModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->setTemplate('module:activateaccountbyemail/views/templates/front/email-sent-message.tpl');
    }
}