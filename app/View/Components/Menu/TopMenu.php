<?php

declare(strict_types=1);

namespace App\View\Components\Menu;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TopMenu extends Component
{
    /**
     * @var list<array{label: string, route: string, pattern: string, dropdown?: string}>
     */
    public array $navItems;

    public Collection $countries;

    public function __construct()
    {
        $this->countries = Country::query()->published()->ordered()->get();

        $this->navItems = [
            ['label' => 'Главная', 'route' => 'home', 'pattern' => 'home'],
            ['label' => 'Страны', 'route' => 'countries.index', 'pattern' => 'countries.*', 'dropdown' => 'countries'],
            ['label' => 'Горящие туры', 'route' => 'hottours.index', 'pattern' => 'hottours.*'],
            ['label' => 'Отзывы', 'route' => 'reviews.index', 'pattern' => 'reviews.*'],
            ['label' => 'О нас', 'route' => 'about.show', 'pattern' => 'about.*'],
            ['label' => 'Документы', 'route' => 'documents.index', 'pattern' => 'documents.*'],
            ['label' => 'Контакты', 'route' => 'contacts.show', 'pattern' => 'contacts.*'],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.top-menu');
    }
}
