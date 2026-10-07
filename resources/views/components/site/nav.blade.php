@props(['items' => config('losos.navigation')])

<ul {{ $attributes->class(['navbar-nav']) }}>
    @foreach ($items as $route => $label)
        @php($active = request()->routeIs($route) || request()->routeIs($route.'.*'))
        <li class="nav-item">
            <a @class(['nav-link', 'active' => $active])
               href="{{ route($route) }}"
               @if ($active) aria-current="page" @endif>
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>
