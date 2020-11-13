<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use tiFy\Container\ServiceProvider;

class ContactInfosServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        'contact-infos'
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (($wp = $this->getContainer()->get('wp')) && $wp->is()) {
            add_action('after_setup_theme', function () {
                $this->getContainer()->get('theme-suite')->boot();
            });
        }
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->getContainer()->share('theme-suite', function () {
            $infos = get_option('contact_infos');

            return new ContactInfos(array_merge(config('contact-infos', []), compact('infos')), $this->getContainer());
        });
    }
}