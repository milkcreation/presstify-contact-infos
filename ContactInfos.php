<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use Psr\Container\ContainerInterface as Container;
use tiFy\Plugins\ContactInfos\{
    Contracts\ContactInfos as ContactInfosContract,
    Metabox\ContactInfosMetabox
};
use tiFy\Support\{ParamsBag, Proxy\Metabox};

/**
 * @desc Extension PresstiFy de gestion d'informations de contact.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package tiFy\Plugins\ContactInfos
 * @version 2.0.1
 *
 * USAGE :
 * Activation
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans config/app.php
 * >> ajouter ContactInfosServiceProvider à la liste des fournisseurs de services.
 * <?php
 *
 * return [
 *      ...
 *      'providers' => [
 *          ...
 *          tiFy\Plugins\ContactInfos\ContactInfosServiceProvider::class
 *          ...
 *      ]
 * ];
 *
 * Configuration
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans le dossier de config, créer le fichier contact-infos.php
 * @see /vendor/presstify-plugins/contact-infos/Resources/config/contact-infos.php
 */
class ContactInfos implements ContactInfosContract
{
    /**
     * Instance de l'extension de gestion des informations de contact.
     * @var ContactInfosContract|null
     */
    protected static $instance;

    /**
     * Instance du gestionnaire d'injection de dépendances.
     * @var Container
     */
    protected $container;

    /**
     * Liste des paramètres de configuration.
     * @var ParamsBag
     */
    protected $infos;

    /**
     * CONSTRUCTEUR.
     *
     * @param Container $container
     *
     * @return void
     */
    public function __construct(?Container $container = null)
    {
        if (!static::$instance instanceof ContactInfosContract) {
            static::$instance = $this;

            if (!is_null($container)) {
                $this->setContainer($container);
            }

            Metabox::registerDriver('contact-infos', (new ContactInfosMetabox())->setContactInfos($this));

            add_action('init', function () {
                if ($config = config('contact-infos', true)) {
                    $defaults = [
                        'admin' => false,
                    ];

                    config([
                        'contact-infos' => is_array($config) ? array_merge($defaults, $config) : $defaults,
                    ]);

                    if ($admin = config('contact-infos.admin')) {
                        $defaults = ['params' => []];
                        if ($fields = config('contact-infos.fields', [])) {
                            $defaults['params']['fields'] = $fields;
                        }
                        if ($groups = config('contact-infos.groups', [])) {
                            $defaults['params']['groups'] = $groups;
                        }

                        $attrs = is_array($admin) ? array_merge($defaults, $admin) : $defaults;
                        $attrs['driver'] = 'contact-infos';

                        Metabox::add('ContactInfos', array_merge($attrs, [
                            'driver' => 'contact-infos'
                        ]))->setScreen('tify_options@options')->setContext('tab');
                    }
                }
            });
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): ?ContactInfosContract
    {
        return static::$instance;
    }

    /**
     * @inheritDoc
     */
    public function getContainer(): ?Container
    {
        return $this->container;
    }

    /**
     * @inheritDoc
     */
    public function infos($key = null, $default = null)
    {
        if (is_null($this->infos)) {
            $this->infos = (new ParamsBag())->set(get_option('contact_infos') ? : []);
        }

        if (is_string($key)) {
            return $this->infos->get($key, $default);
        } elseif (is_array($key)) {
            return $this->infos->set($key);
        } else {
            return $this->infos;
        }
    }

    /**
     * @inheritDoc
     */
    public function resources($path = ''): string
    {
        $path = $path ? '/' . ltrim($path, '/') : '';

        return file_exists(__DIR__ . "/Resources{$path}") ? __DIR__ . "/Resources{$path}" : '';
    }

    /**
     * @inheritDoc
     */
    public function setContainer(Container $container): ContactInfosContract
    {
        $this->container = $container;

        return $this;
    }
}
