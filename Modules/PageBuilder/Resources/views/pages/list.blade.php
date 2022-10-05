<table id="lms_table" class="table Crm_table_active3">
    <thead>
    <tr>
        <th>{{__('page-builder.SL')}}</th>
        <th>{{__('page-builder.Title')}}</th>
        <th>{{__('page-builder.Slug')}}</th>
        <th>{{__('page-builder.Status')}}</th>
        <th>{{__('common.Action')}}</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$row->title}}</td>
            <td>{{$row->slug}}</td>
            <td>
                <label class="switch_toggle" for="checkbox{{ $row->id }}">
                    <input type="checkbox" id="checkbox{{ $row->id }}" data-id="{{ $row->id }}" class="status_change" {{ $row->status ? 'checked' : '' }} value="{{ $row->id }}">
                    <div class="slider round"></div>
                </label>
            </td>
            <td>
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('common.Select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        @if(permissionCheck('page_builder.pages.design.update'))
                            <a href="{{route('page_builder.pages.design',$row->id)}}" class="dropdown-item">{{ __('page-builder.Design') }}</a>
                        @endif
                        @if(permissionCheck('page_builder.pages.show'))
                            <a href="{{route('page_builder.pages.show',$row->id)}}" class="dropdown-item">{{ __('common.View') }}</a>
                        @endif
                        @if(permissionCheck('page_builder.pages.update'))
                            <a href="#" class="dropdown-item edit_row" data-id="{{ $row->id }}">{{ __('common.Edit') }}</a>
                        @endif
                        @if(permissionCheck('page_builder.pages.destroy'))
                            <a href="#" class="dropdown-item delete_row" data-id="{{ $row->id }}" type="button">{{ __('common.Delete') }}</a>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
