<?php declare(strict_types=1);

use tiFy\Plugins\ContactInfos\ContactInfos;

if (!function_exists('contact_infos')) {
    /**
     * Récupération de la liste des informations de contact ou d'un attributs particulier.
     *
     * @param string|null $key
     * @param mixed $default
     *
     * @return mixed
     */
    function contact_infos(?string $key = null, $default = null)
    {
        try {
            $cinfos = ContactInfos::instance();

            return is_null($key)
                ? $cinfos->config()->get('datas', []) : $cinfos->config()->get("datas.{$key}", $default);
        } catch(Exception $e) {
            return $default;
        }
    }
}