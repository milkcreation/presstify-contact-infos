<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

class ContactInfosField extends AbstractContactInfosBag
{
    /**
     * Récupération de la clé d'indice de qualification de la valeur en base.
     *
     * @return string
     */
    public function getName(): string
    {
        $key = $this->get('name', '') ? : $this->getAlias();

        return $this->metabox->name(). "[{$key}]";
    }

    /**
     * Récupération de la valeur enregistrée en base.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function getValue($default = null)
    {
        return $this->metabox->value($this->get('name', ''), $default);
    }

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->get('title', '') ? : $this->getAlias();
    }

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function render(): string
    {
        $tmpl = "field-{$this->getAlias()}";

        if (!$this->metabox->viewer()->exists($tmpl)) {
            $tmpl = 'tmpl-field';
        }

        return $this->metabox->viewer($tmpl, ['field' => $this]);
    }
}