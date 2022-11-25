<?php
class Combination extends CombinationCore
{
    public $availability;
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        self::$definition['fields']['availability'] = [
            'type' => self::TYPE_INT,
            'required' => false,
        ];
        parent::__construct($id, $id_lang, $id_shop);
    }
}