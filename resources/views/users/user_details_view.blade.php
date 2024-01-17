<div class="row">
    @if ($flag == 1)
        <div class="col-md-12 text-center">
            <div class="col-md-12 mb-7">
                @foreach ($companies as $val)
                    @if (isset($user_details->company_id) && $user_details->company_id == $val->id)
                        <h3> {{ $val->company_name }} </h3>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <div class="col-md-2">
        <div class="row">
            {{-- <div class="symbol symbol-100px symbol-circle mb-7">
                <img src="{{(isset($user_details->profile_pic) && !empty($user_details->profile_pic)) ? url($user_details->profile_pic) : ''}}}}" alt="image">
            </div> --}}
            <div class="col-md-12 mb-7">
                <style>
                    .image-input-placeholder {
                        background-image: url('assets/media/svg/files/blank-image.svg');
                    }

                    [data-bs-theme="dark"] .image-input-placeholder {
                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                    }
                </style>
                <div class="image-input image-input-outline image-input-placeholder {{ isset($user_details->profile_pic) && !empty($user_details->profile_pic) ? '' : 'image-input-empty' }}"
                    data-kt-image-input="true">
                    <div class="image-input-wrapper w-150px h-150px"
                        style="background-image: {{ isset($user_details->profile_pic) && !empty($user_details->profile_pic) ? 'url(' . $user_details->profile_pic . ')' : 'none' }};">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="fv-row">
            <h4>{{ isset($user_details->name) && !empty($user_details->name) ? 'Name: ' . $user_details->name : '-' }}
            </h4>
        </div>

        <div class="fv-row">
            <h4 style="color: #2584ff;">
                {{ isset($user_details->email) && !empty($user_details->email) ? 'Email: ' . $user_details->email : '-' }}
            </h4>
        </div>
        <div class="fv-row">
            <h4>{{ isset($user_details->role_name) && !empty($user_details->role_name) ? 'Phone: ' . $user_details->role_name : '-' }}
            </h4>
        </div>
    </div>
</div>
<div class="text-center pt-10">
    <a href="{{ isset($routeName) && $routeName == 'superadmin.users' ? url('/superadmin/user/edit') . '/' . $user_details->id : url('/user/edit') . '/' . $user_details->id }}"
        class="btn btn-primary me-3">Edit</a>
</div>
