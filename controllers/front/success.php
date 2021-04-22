<?php

class activateaccountbyemailsuccessModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        $this->context->smarty->assign([
            'letsLoginLink' => $this->context->link->getPageLink('authentication')
        ]);

        $this->setTemplate('module:activateaccountbyemail/views/templates/front/success.tpl');
    }
}
