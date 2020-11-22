<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

class ContactInfosGroupBag extends AbstractContactInfosBag
{
    /**
     * Instance des champs à afficher.
     * @var ContactInfosFieldBag[]|array
     */
    protected $fields = [];

    /**
     * Récupération de la liste des champs à afficher.
     *
     * @return ContactInfosFieldBag[]|array
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