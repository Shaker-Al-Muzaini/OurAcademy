@php
    $pageBuilder= false;

    if(request()->is('page-builder/*'))
    {
        $pageBuilder = true;
    }
@endphp
<li class="{{ $pageBuilder ?'mm-active' : '' }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $pageBuilder ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-industry"></span>
        </div>
        <div class="nav_title">
            <span>{{__('page-builder.Page Builder')}}</span>
        </div>
    </a>
    <ul>
        @if(permissionCheck('page_builder.pages.index'))
            <li>
                <a href="{{route('page_builder.pages.index')}}" class="{{request()->routeIs('page_builder.pages.*') ? 'active' : ''}}">{{__('page-builder.Pages')}}</a>
            </li>
        @endif
    </ul>
</li>

