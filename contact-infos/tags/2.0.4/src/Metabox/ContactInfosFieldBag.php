<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

class ContactInfosFieldBag extends AbstractContactInfosBag
{
    /**
     * Récupération de la clé d'indice de qualification de la valeur en base.
     *
     * @return string
     */
    public function getName(): string
    {
        $name = $this->get('name', '') ? : $this->getAlias();
        $group = $this->get('group', '');

        return $this->metabox->name() . '[datas]' . ($group ? "[{$group}]" : '') . "[{$name}]";
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
        $name = $this->get('name', '') ? : $this->getAlias();
        $group = $this->get('group', '');

        return $this->metabox->value('datas.' . ($group ? "{$group}." : '') . $name, $default);
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

        if (!$this->metabox->view()->exists($tmpl)) {
            $tmpl = 'tmpl-field';
        }

        return $this->metabox->view($tmpl, ['field' => $this]);
    }
}