<ul class="top_menu">
    @foreach ($navItems as $item)
        <li class="{{ request()->routeIs($item['pattern']) ? 'active' : '' }}">
            <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>

            @if (($item['dropdown'] ?? null) === 'countries' && $countries->isNotEmpty())
                <ul class="submenu">
                    @foreach ($countries as $country)
                        <li><a href="{{ route('countries.show', $country->slug) }}">{{ $country->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
