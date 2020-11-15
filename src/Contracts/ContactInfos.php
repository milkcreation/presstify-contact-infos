<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Contracts;

use Exception;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Contracts\Support\ParamsBag;

interface ContactInfos
{
    /**
     * Récupération de l'instance de l'extension gestion d'optimisation.
     *
     * @return static
     *
     * @throws Exception
     */
    public static function instance(): ContactInfos;

    /**
     * Initialisation du gestionnaire d'optimisation.
     *
     * @return static
     */
    public function boot(): ContactInfos;

    /**
     * Récupération de paramètre|Définition de paramètres|Instance du gestionnaire de paramètre.
     *
     * @param string|array|null $key Clé d'indice du paramètre à récupérer|Liste des paramètre à définir.
     * @param mixed $default Valeur de retour par défaut lorsque la clé d'indice est une chaine de caractère.
     *
     * @return mixed|ParamsBag
     */
    public function config($key = null, $default = null);

    /**
     * Récupération du conteneur d'injection de dépendances.
     *
     * @return Container|null
     */
    public function getContainer(): ?Container;

    /**
     * Récupération d'un service fourni par le conteneur d'injection de dépendance.
     *
     * @param string $name
     *
     * @return callable|object|string|null
     */
    public function getProvider(string $name);

    /**
     * Résolution de service fourni par le gestionnaire d'abonnments.
     *
     * @param string $alias
     *
     * @return object|mixed|null
     */
    public function resolve(string $alias);

    /**
     * Vérification de résolution possible d'un service fourni par le gestionnaire d'abonnments.
     *
     * @param string $alias
     *
     * @return bool
     */
    public function resolvable(string $alias): bool;

    /**
     * Chemin absolu vers une ressources (fichier|répertoire).
     *
     * @param string|null $path Chemin relatif vers la ressource.
     *
     * @return LocalFilesystem|string|null
     */
    public function resources(?string $path = null);

    /**
     * Définition des paramètres de configuration.
     *
     * @param array $attrs Liste des attributs de configuration.
     *
     * @return static
     */
    public function setConfig(array $attrs): ContactInfos;

    /**
     * Définition du conteneur d'injection de dépendances.
     *
     * @param Container $container
     *
     * @return static
     */
    public function setContainer(Container $container): ContactInfos;
}
