 <!--begin::details View-->
 <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
     <!--begin::Card header-->
     <div class="card-header cursor-pointer">
         <!--begin::Card title-->
         <div class="card-title m-0">
             <h3 class="fw-bold m-0">Profile Details</h3>
         </div>
         <!--end::Card title-->
         <!--begin::Action-->
         <a href="{{ url('/myprofile/settings') }}" class="btn btn-sm btn-primary align-self-center">Edit
             Profile</a>
         <!--end::Action-->
     </div>
     <!--begin::Card header-->
     <!--begin::Card body-->
     <div class="card-body p-9">
         <!--begin::Row-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span class="fw-bold fs-6 text-gray-800">{{ !empty($user->name) ? $user->name : '-' }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Row-->
         <!--begin::Row Email-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Email</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span class="fw-bold fs-6 text-gray-800">{{ !empty($user->email) ? $user->email : '-' }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Row-->
         <!--begin::Input group Phone-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Phone
                 <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                     <i class="ki-duotone ki-information fs-7">
                         <span class="path1"></span>
                         <span class="path2"></span>
                         <span class="path3"></span>
                     </i>
                 </span></label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8 d-flex align-items-center">
                 <span class="fw-bold fs-6 text-gray-800 me-2">{{ !empty($user->phone) ? $user->phone : '-' }}</span>
                 {{-- <span class="badge badge-success">Verified</span> --}}
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
         <!--begin::Input group Company-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Company</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8 fv-row">
                 <span
                     class="fw-semibold text-gray-800 fs-6">{{ !empty($company->company_name) ? $company->company_name : ($flag == 1 ? 'mTrack' : '-') }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
         <!--begin::Input group company_website-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Company Site</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <a href="{{ !empty($company->company_website) ? $company->company_website : ($flag == 1 ? url('') : '-') }}"
                     class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ !empty($company->company_website) ? $company->company_website : ($flag == 1 ? url('') : '-') }}</a>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
         <!--begin::Row Role-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Role</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span
                     class="fw-bold fs-6 text-gray-800">{{ isset($role->id) ? (!empty($role->title) ? $role->title : '-') : '-' }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Row-->
         <!--begin::Input group Country-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Country
                 <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                     <i class="ki-duotone ki-information fs-7">
                         <span class="path1"></span>
                         <span class="path2"></span>
                         <span class="path3"></span>
                     </i>
                 </span></label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span class="fw-bold fs-6 text-gray-800">{{ isset($country) ? $country : '-' }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
         <!--begin::Input group Communication-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Communication</label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span
                     class="fw-bold fs-6 text-gray-800">{{ (!empty($user->email) ? 'Email' . (!empty($user->phone) ? ',' : '') : '') . (!empty($user->phone) ? 'Phone' : '') }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
         <!--begin::Input group Language-->
         <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">Language
                 <span class="ms-1" data-bs-toggle="tooltip" title="Language of origination">
                     <i class="ki-duotone ki-information fs-7">
                         <span class="path1"></span>
                         <span class="path2"></span>
                         <span class="path3"></span>
                     </i>
                 </span></label>
             <!--end::Label-->
             <!--begin::Col-->
             <div class="col-lg-8">
                 <span class="fw-bold fs-6 text-gray-800">{{ isset($language) ? $language : '-' }}</span>
             </div>
             <!--end::Col-->
         </div>
         <!--end::Input group-->
     </div>
     <!--end::Card body-->
 </div>
 <!--end::details View-->
