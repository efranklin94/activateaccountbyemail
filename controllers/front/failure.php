<?php

class activateaccountbyemailfailureModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->setTemplate('module:activateaccountbyemail/views/templates/front/failure.tpl');
    }
}