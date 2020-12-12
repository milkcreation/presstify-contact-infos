<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

use tiFy\Support\ParamsBag;

abstract class AbstractContactInfosBag extends ParamsBag
{
    /**
     * Alias de qualification.
     * @var string
     */
    protected $alias = '';

    /**
     * Indicateur d'initialisation.
     * @var bool
     */
    protected $built = false;

    /**
     * Instance de la métaboxe associée.
     * @var ContactInfosMetabox|null
     */
    protected $metabox;

    /**
     * Récupération de l'alias de qualification.
     *
     * @return static
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Initialisation de l'élément.
     *
     * @return static
     */
    public function build(): self
    {
        if (!$this->built) {
            $this->parse();

            $this->built = true;
        }

        return $this;
    }

    /**
     * Déclaration de l'alias de qualification.
     *
     * @param ContactInfosMetabox $metabox
     *
     * @return static
     */
    public function setMetabox(ContactInfosMetabox $metabox): self
    {
        $this->metabox = $metabox;

        return $this;
    }

    /**
     * Déclaration de l'alias de qualification.
     *
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }
}