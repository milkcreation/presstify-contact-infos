<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Metabox;

use Illuminate\Support\Collection;
use tiFy\Plugins\ContactInfos\Contracts\ContactInfos;
use tiFy\Contracts\Metabox\MetaboxDriver as MetaboxDriverContract;
use tiFy\Metabox\MetaboxDriver;

class ContactInfosMetabox extends MetaboxDriver
{
    /**
     * @inheritDoc
     */
    protected $alias = 'contact-infos';

    /**
     * Instance du gestionnaire de l'extension ContactInfos.
     * @var ContactInfos|null
     */
    protected $contactInfos;

    /**
     * Liste des instances de champs déclarés.
     * @var ContactInfosField[]|array
     */
    protected $fields = [];

    /**
     * Liste des instances de groupe de champs déclarés.
     * @var ContactInfosGroup[]|array
     */
    protected $groups = [];

    /**
     * Déclaration d'un champ.
     *
     * @param string $alias
     * @param array|ContactInfosField $args
     *
     * @return $this
     */
    public function addField(string $alias, $args = []): self
    {
        $field = $args instanceof ContactInfosField ? $args : (new ContactInfosField())->set($args);

        $this->fields[$alias] = $field->setMetabox($this)->setAlias($alias);

        return $this;
    }

    /**
     * Déclaration d'un groupe de champ.
     *
     * @param string $alias
     * @param array|ContactInfosGroup $args
     *
     * @return $this
     */
    public function addGroup(string $alias, $args = []): self
    {
        $group = $args instanceof ContactInfosGroup ? $args : (new ContactInfosGroup())->set($args);

        $this->groups[$alias] = $group->setMetabox($this)->setAlias($alias);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        parent::boot();

        $fields = [
            'address1' => [
                'group'    => 'contact',
                'name'     => 'contact_address1',
                'title'    => __('Adresse Postale', 'tify')
            ],
            'address2' => [
                'group'    => 'contact',
                'name'     => 'contact_address2',
                'title'    => __('Adresse complémentaire', 'tify')
            ],
            'address3' => [
                'group'    => 'contact',
                'name'     => 'contact_address3',
                'title'    => __('Informations supplémentaires concernant l\'adresse', 'tify')
            ],
            'city'     => [
                'group'    => 'contact',
                'name'     => 'contact_city',
                'title'    => __('Ville', 'tify')
            ],
            'postcode' => [
                'group'    => 'contact',
                'name'     => 'contact_postcode',
                'title'    => __('Code postal', 'tify')
            ],
            'country'     => [
                'group'    => 'contact',
                'name'     => 'contact_country',
                'title'    => __('Pays', 'tify')
            ],
            'phone'    => [
                'group'    => 'contact',
                'name'     => 'contact_phone',
                'title'    => __('Numéro de téléphone', 'tify')
            ],
            'fax'      => [
                'group'    => 'contact',
                'name'     => 'contact_fax',
                'title'    => __('Numéro de fax', 'tify')
            ],
            'email'    => [
                'group'    => 'contact',
                'name'     => 'contact_email',
                'title'    => __('Adresse de messagerie', 'tify')
            ],
            'website'    => [
                'group'    => 'contact',
                'name'     => 'contact_website',
                'title'    => __('Site internet', 'tify')
            ],
            'map'      => [
                'group' => 'contact',
                'name'  => 'contact_map',
                'title' => __('Carte', 'theme'),
            ],
            'maplink'  => [
                'group' => 'contact',
                'name'  => 'contact_maplink',
                'title' => __('Lien vers la carte interactive', 'theme'),
            ],
            'company'  => [
                'group'    => 'company',
                'name'     => 'company_name',
                'title'    => __('Nom de la société', 'tify')
            ],
            'form'     => [
                'group'    => 'company',
                'name'     => 'company_form',
                'title'    => __('Forme juridique', 'tify')
            ],
            'siren'    => [
                'group'    => 'company',
                'name'     => 'company_siren',
                'title'    => __('Numéro de SIREN', 'tify')
            ],
            'siret'    => [
                'group'    => 'company',
                'name'     => 'company_siret',
                'title'    => __('Numéro de SIRET', 'tify')
            ],
            'tva'      => [
                'group'    => 'company',
                'name'     => 'company_tva',
                'title'    => __('N° de TVA Intracommunautaire', 'tify')
            ],
            'ape'      => [
                'group'    => 'company',
                'name'     => 'company_ape',
                'title'    => __('Activité (Code NAF ou APE)', 'tify')
            ],
            'cnil'     => [
                'group'    => 'company',
                'name'     => 'company_cnil',
                'title'    => __('Déclaration CNIL', 'tify')
            ],
            'opening'  => [
                'group' => 'company',
                'name'  => 'company_opening',
                'title' => __('Horaires d\'ouverture', 'theme'),
            ]
        ];

        foreach ($fields as $alias => $field) {
            $this->addField($alias, $field);
        }

        $groups = [
            'contact' => [
                'title'    => __('Informations de contact', 'theme'),
            ],
            'company' => [
                'title'    => __('Informations sur la société', 'theme'),
            ],
        ];

        foreach ($groups as $alias => $group) {
            $this->addGroup($alias, $group);
        }
    }

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'name'  => 'contact_infos',
            'title' => __('Informations de contact', 'tify'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return [
            'fields' => ['address1', 'address2', 'city', 'postcode', 'phone', 'email'],
            'groups' => ['contact'],
        ];
    }

    /**
     * Récupération de la liste des champs associé à un groupe.
     *
     * @param string $group Alias de qualification du groupe.
     *
     * @return ContactInfosField[]|array
     */
    public function getFields(string $group): array
    {
        $exists = $this->params('fields', []);
        $fields = [];

        foreach ($exists as $alias) {
            if (isset($this->fields[$alias])) {
                $fields[$alias] = $this->fields[$alias]->build();
            }
        }

        return (new Collection($fields))->filter(function ($field) use ($group) {
            return $field->group === $group;
        })->sortBy('position')->all();
    }

    /**
     * Récupération de la liste des groupes de champs.
     *
     * @return ContactInfosGroup[]|array
     */
    public function getGroups(): array
    {
        $aliases = $this->params('groups', []);
        $groups = [];

        foreach ($aliases as $alias) {
            if (isset($this->groups[$alias])) {
                $groups[$alias] = $this->groups[$alias]->build();
            }
        }

        return (new Collection($groups))->sortBy('position')->all();
    }

    /**
     *
     */
    public function parse(): MetaboxDriverContract
    {
        parent::parse();

        if (!$this->has('viewer.directory')) {
            $this->set('viewer.directory', $this->contactInfos->resources('/views/admin/metabox/'));
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('groups', $this->getGroups());

        return parent::render();
    }

    /**
     * Définition du gestionnaire de l'extension ContactInfos.
     *
     * @param ContactInfos $contact_infos
     *
     * @return $this
     */
    public function setContactInfos(ContactInfos $contact_infos): MetaboxDriverContract
    {
        $this->contactInfos = $contact_infos;

        return $this;
    }
}