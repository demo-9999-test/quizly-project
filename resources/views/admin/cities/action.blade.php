<div class="dropdown action-dropdown">
    <a class="dropdown-toggle" title="{{__('Dots')}}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="flaticon-dots"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            @can('packages_features.delete')
                <a class="dropdown-item" href="#" title="{{__('Delete')}}" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $city->id }}" title="{{ __('Delete')}}">
                    <i class="flaticon-delete"></i> {{ __('Delete')}}
                </a>
            @endcan
        </li>
    </ul>
</div>

<!-- Modal for delete confirmation -->
<!-- Modal for delete confirmation -->
<div class="modal fade" id="exampleModal{{ $city->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Are You Sure ?') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete') }}? {{ __('This process cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ url('admin/cities/' . $city->id . '/delete') }}" class="pull-right">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="reset" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->

