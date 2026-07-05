<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact;

use App\Models\Contact;
use App\MoonShine\Resources\Contact\Pages\ContactFormPage;
use App\MoonShine\Resources\Contact\Pages\ContactIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Contact, ContactIndexPage, ContactFormPage, null>
 */
#[Icon('phone')]
#[Group('Каталог', 'building-office-2')]
class ContactResource extends ModelResource
{
    protected string $model = Contact::class;

    protected string $column = 'phone';

    protected array $with = ['site'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Контакты';
    }

    protected function pages(): array
    {
        return [
            ContactIndexPage::class,
            ContactFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'phone',
            'email',
        ];
    }
}
