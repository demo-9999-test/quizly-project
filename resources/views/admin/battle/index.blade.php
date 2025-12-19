@extends('admin.layouts.master')
@section('title', 'Battle')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Battle') }}
        @endslot
        @slot('menu1')
            {{ __('Battle') }}
        @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="client-detail-block">
                            <form action="{{ route('battle.createOrUpdate') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h5 class="block-heading">{{__('Add Battle')}}</h5>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="battleName" class="form-label">{{ __('Battle  Name') }}<span class="required">*</span></label>
                                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="battleName" placeholder="{{ __('Enter Name of your Battle') }}" aria-label="Battle Name" value="{{ isset($battle->name) ? $battle->name : '' }}" oninput="updateBattlePreview()">
                                                    <div class="form-control-icon"><i class="flaticon-swords"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-8 col-8">
                                                            <label for="image" class="form-label">{{ __('Image') }}<span class="required">*</span></label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-4">
                                                            <div class="suggestion-icon float-end">
                                                                <div class="tooltip-icon">
                                                                    <div class="tooltip">
                                                                        <div class="credit-block">
                                                                            <small class="recommended-font-size">{{ __('Recommended Size : 720x900') }}</small>
                                                                        </div>
                                                                    </div>
                                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" type="file" name="image" id="image" accept="image/*" onchange="previewImageBattle(event)">
                                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="room_time" class="form-label">{{ __('Battle Room Time') }}<span class="required">*</span></label>
                                                    <input class="form-control @error('room_time') is-invalid @enderror" type="number" name="room_time" id="room_time" placeholder="{{ __('Battle Room time') }}" aria-label="room_time" value="{{ isset($battle->room_time) ? $battle->room_time : '' }}" oninput="updateBattlePreview()">
                                                    <div class="form-control-icon"><i class="flaticon-clock"></i></div>
                                                </div>
                                            </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="desc" class="form-label">{!! __('Description') !!}<span class="required">*</span></label>
                                                        <textarea class="form-control" id="desc" name="desc" placeholder="{!! __('Enter Description') !!}" oninput="updateBattlePreview()">{{ isset($battle->description) ? $battle->description : '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ isset($battle->status) && $battle->status == 1 ? 'checked' : '' }} onchange="updateBattlePreview()">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="client-detail-block">
                                <h5 class="block-heading">{{__('Current Battle Information')}}</h5>
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <h5 class="mb-3">Battle Name: <span id="preview_battle_name">{{ $battle->name ?? 'N/A' }}</span></h5>
                                        <h5 class="mb-3">Battle Room Time: <span id="preview_battle_time">{{ $battle->room_time ?? 'N/A' }}</span> minutes</h5>
                                        <h5>Status: <span id="preview_battle_status">{{ isset($battle) && $battle->status ? 'Active' : 'Inactive' }}</span></h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <img id="preview_battle_image" 
                                            src="{{ isset($battle->image) ? asset('images/battle/' . $battle->image) : '#' }}" 
                                            class="img-fluid {{ isset($battle->image) ? '' : 'd-none' }}" 
                                            alt="Battle Image">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div id="preview_battle_desc">{!! $battle->description ?? 'No description provided.' !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Declare editor globally
    let editorDesc;

    // Initialize Jodit Editor after DOM is ready
    document.addEventListener("DOMContentLoaded", function () {
        editorDesc = new Jodit('#desc', {
            height: 300,
            events: {
                change: function () {
                    updateBattlePreview();
                }
            }
        });
    });

    function updateBattlePreview() {
        let name = document.getElementById('battleName').value;
        let time = document.getElementById('room_time').value;
        let status = document.getElementById('status').checked;

        // Get HTML content from Jodit
        let desc = editorDesc ? editorDesc.getEditorValue() : '';

        document.getElementById('preview_battle_name').innerText = name || 'N/A';
        document.getElementById('preview_battle_time').innerText = time || 'N/A';
        document.getElementById('preview_battle_desc').innerHTML = desc || 'No description provided.';
        document.getElementById('preview_battle_status').innerText = status ? 'Active' : 'Inactive';
    }

    function previewImage(event) {
        let output = document.getElementById('preview_battle_image');
        let file = event.target.files[0];

        if (file) {
            output.src = URL.createObjectURL(file);
            output.onload = function () {
                URL.revokeObjectURL(output.src); // Free memory
            }

            // Agar "No image uploaded" p tag ho to usse hide karo
            let nextElem = output.nextElementSibling;
            if (nextElem && nextElem.tagName === 'P') {
                nextElem.style.display = 'none';
            }
        }
    }
</script>
@endsection