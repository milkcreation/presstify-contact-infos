<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos\Contracts;

use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Support\ParamsBag;

interface ContactInfos
{
    /**
     * Récupération de l'instance de l'extension gestion des informations de contact.
     *
     * @return static|null
     */
    public static function instance(): ?ContactInfos;

    /**
     * Récupération du conteneur d'injection de dépendances.
     *
     * @return Container|null
     */
    public function getContainer(): ?Container;

    /**
     * Récupération d'information|Définition d'informations|Instance des informations de contact.
     *
     * @param string|array|null $key Clé d'indice du paramètre à récupérer|Liste des paramètre à définir.
     * @param mixed $default Valeur de retour par défaut lorsque la clé d'indice est une chaine de caractère.
     *
     * @return mixed|ParamsBag
     */
    public function infos($key = null, $default = null);

    /**
     * Chemin absolu vers une ressources (fichier|répertoire).
     *
     * @param string $path Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function resources($path = ''): string;

    /**
     * Définition du conteneur d'injection de dépendances.
     *
     * @param Container $container
     *
     * @return static
     */
    public function setContainer(Container $container): ContactInfos;
}
