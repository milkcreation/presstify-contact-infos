<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use Exception;
use tiFy\Plugins\ContactInfos\Contracts\ContactInfos;

trait ContactInfosAwareTrait
{
    /**
     * Instance de l'application.
     * @var ContactInfos|null
     */
    private $cinfos;

    /**
     * Récupération de l'instance de l'application.
     *
     * @return ContactInfos|null
     */
    public function cinfos(): ?ContactInfos
    {
        if (is_null($this->cinfos)) {
            try {
                $this->cinfos = ContactInfos::instance();
            } catch (Exception $e) {
                $this->cinfos;
            }
        }

        return $this->cinfos;
    }

    /**
     * Définition de l'application.
     *
     * @param ContactInfos $cinfos
     *
     * @return static
     */
    public function setContactInfos(ContactInfos $cinfos): self
    {
        $this->cinfos = $cinfos;

        return $this;
    }
}