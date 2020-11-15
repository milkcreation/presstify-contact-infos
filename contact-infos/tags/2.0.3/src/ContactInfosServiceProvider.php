<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use tiFy\Container\ServiceProvider;
use tiFy\Plugins\ContactInfos\Contracts\ContactInfos as ContactInfosContract;

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
            add_action('after_setup_theme', function (): ContactInfosContract {
                /** @var ContactInfosContract $cinfos */
                $cinfos = $this->getContainer()->get('contact-infos');

                if ($options = get_option('contact_infos') ?: null) {
                    $cinfos->config($options);
                }

                return $cinfos->boot();
            });
        }
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->getContainer()->share('contact-infos', function () {
            return new ContactInfos(config('contact-infos', []), $this->getContainer());
        });
    }
}