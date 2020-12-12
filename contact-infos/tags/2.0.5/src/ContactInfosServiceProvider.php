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
        ContactInfosContract::class,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            /** @var ContactInfosContract $cinfos */
            $cinfos = $this->getContainer()->get(ContactInfosContract::class);

            if ($options = get_option('contact_infos') ?: null) {
                $cinfos->config($options);
            }

            return $cinfos->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->getContainer()->share(ContactInfosContract::class, function () {
            return new ContactInfos(config('contact-infos', []), $this->getContainer());
        });
    }
}