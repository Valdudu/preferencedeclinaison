<?php
/**
 * 2007-2022 PrestaShop
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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2022 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Preferencedeclinaison extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'preferencedeclinaison';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Valentin Duplan';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Preferences de livraison pour les déclinaisons de produits');
        $this->description = $this->l('Ajoute des preferences de livraison pour les déclinaisons de produits');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('PREFERENCEDECLINAISON_LIVE_MODE', false);
        include(__DIR__ . '/sql/install.php');
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayAdminProductsCombinationBottom') &&
            $this->registerHook('actionProductAttributeUpdate');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PREFERENCEDECLINAISON_LIVE_MODE');
        include(__DIR__ . '/sql/uninstall.php');
        return parent::uninstall();
    }

    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/front.css');
    }
    public function hookDisplayAdminProductsCombinationBottom($params)
    {
        $combi = new Combination($params['id_product_attribute']);
        $this->context->smarty->assign([
            'combination' => $combi->availability,
            'id_product_attribute' => $params['id_product_attribute']
        ]);
        return $this->display(__FILE__, 'views/templates/admin/hook/combination.tpl');
    }
    public function hookActionProductAttributeUpdate($params)
    {
        Db::getInstance()->execute('UPDATE ' . _DB_PREFIX_ . 'product_attribute set availability = \'' . Tools::getValue('pref_' . $params['id_product_attribute']) . '\'
        WHERE id_product_attribute = ' . $params['id_product_attribute']);
    }
}