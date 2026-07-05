<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Review;

use App\Models\Review;
use App\MoonShine\Resources\Review\Pages\ReviewFormPage;
use App\MoonShine\Resources\Review\Pages\ReviewIndexPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\Support\Attributes\Icon;

/**
 * @extends ModelResource<Review, ReviewIndexPage, ReviewFormPage, null>
 */
#[Icon('star')]
#[Group('Каталог', 'building-office-2')]
class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $column = 'author_name';

    protected string $sortColumn = 'sorting';

    protected array $with = ['hotel'];

    protected bool $simplePaginate = true;

    public function getTitle(): string
    {
        return 'Отзывы';
    }

    protected function pages(): array
    {
        return [
            ReviewIndexPage::class,
            ReviewFormPage::class,
        ];
    }

    protected function search(): array
    {
        return [
            'id',
            'author_name',
        ];
    }
}
