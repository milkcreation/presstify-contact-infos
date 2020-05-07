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
        $infos = ContactInfos::instance()->infos();

        return is_null($key) ? $infos->all() : $infos->get($key, $default);
    }
}