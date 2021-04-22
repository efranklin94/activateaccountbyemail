<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Binshops <contact@binshops.com>
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class ActivateAccountByEmail extends Module
{

    public function __construct()
    {
        $this->name = 'activateaccountbyemail';
        $this->version = '1.0.0';
        $this->tab = 'administration';
        $this->author = 'Binshops';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Activate account by email');
        $this->description = $this->l('Customers are forced to activate their account through email.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('createAccount') &&
            Db::getInstance()->Execute('alter table ' . _DB_PREFIX_ . 'customer add email_activation_token char(32)');
    }

    public function uninstall()
    {
        return parent::uninstall() &&
            $this->unregisterHook('createAccount');
    }

    public function hookcreateAccount($req)
    {
        $this->context->customer->logout();

        $activation_token = md5(uniqid(rand(), true));
        $link = $this->context->link->getModuleLink($this->name, 'activate') . '?token=' . $activation_token;

        $sql = sprintf("update %scustomer set active=0, email_activation_token='%s' where id_customer=%d",
                       _DB_PREFIX_, $activation_token, $req['newCustomer']->id);
        Db::getInstance()->Execute($sql);

        $customer = new Customer($req['newCustomer']->id);
        $customer->getFields();

        Mail::Send($this->context->customer->id_lang,
                   'activate_by_email',
                   $this->l('Email Confirmation'),
                   array('{firstname}' => $customer->firstname,
                         '{lastname}' => $customer->lastname,
                         '{email}' => $customer->email,
                         '{link}' => $link),
                   $customer->email,
                   NULL,
                   NULL,
                   NULL,
                   NULL,
                   NULL,
            _PS_MODULE_DIR_ . 'activateaccountbyemail/mails');
        Tools::redirect($this->context->link->getModuleLink($this->name, 'emailsentmessage'));
    }
}
