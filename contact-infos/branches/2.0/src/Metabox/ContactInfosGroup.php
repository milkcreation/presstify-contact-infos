<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

class ContactInfosGroup extends AbstractContactInfosBag
{
    /**
     * Instance des champs à afficher.
     * @var ContactInfosField[]|array
     */
    protected $fields = [];

    /**
     * Récupération de la liste des champs à afficher.
     *
     * @return ContactInfosField[]|array
     */
    public function getFields(): array
    {
        return $this->fields;
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
     * {@inheritDoc}
     *
     * @return static
     */
    public function parse(): self
    {
        parent::parse();

        $this->fields = $this->metabox->getFields($this->getAlias());

        return $this;
    }
}