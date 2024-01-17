@php
    $count = 1;
    $index = 0;
@endphp
<ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
    @for ($i = 0; $i < count($employees); $i++)
        @if ($count == 1)
            <li data-bs-target="#kt_security_guidelines" data-bs-slide-to="{{ $index }}"
                class="ms-1 {{ $i == 0 ? 'active' : '' }}">
            </li>
            @php
                $index++;
            @endphp
        @endif
        @php
            $count++;
            if ($count > 4) {
                $count = 1;
            }
        @endphp
    @endfor
</ol>
