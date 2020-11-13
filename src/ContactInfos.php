<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use Exception;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Plugins\ContactInfos\Contracts\ContactInfos as ContactInfosContract;
use tiFy\Plugins\ContactInfos\Metabox\ContactInfosMetabox;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Metabox;
use tiFy\Support\Proxy\Storage;

class ContactInfos implements ContactInfosContract
{
    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Indicateur d'initialisation.
     * @var bool
     */
    private $booted = false;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [

    ];

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    protected $config;

    /**
     * Instance du gestionnaire d'injection de dépendances.
     * @var Container
     */
    protected $container;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): ContactInfosContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        throw new Exception('Unavailable ContactInfos instance');
    }

    /**
     * @inheritDoc
     */
    public function boot(): ContactInfosContract
    {
        if (!$this->booted) {
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
                            'driver' => 'contact-infos',
                        ]))->setScreen('tify_options@options')->setContext('tab');
                    }
                }
            });

            $this->booted = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->config) || is_null($this->config)) {
            $this->config = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->config->get($key, $default);
        } elseif (is_array($key)) {
            return $this->config->set($key);
        } else {
            return $this->config;
        }
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
    public function getProvider(string $name)
    {
        return $this->config("providers.{$name}", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function resolve(string $alias)
    {
        return ($container = $this->getContainer()) ? $container->get("pwa.{$alias}") : null;
    }

    /**
     * @inheritDoc
     */
    public function resolvable(string $alias): bool
    {
        return ($container = $this->getContainer()) && $container->has("pwa.{$alias}");
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) ||is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__));
        }

        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): ContactInfosContract
    {
        $this->config($attrs);

        return $this;
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
