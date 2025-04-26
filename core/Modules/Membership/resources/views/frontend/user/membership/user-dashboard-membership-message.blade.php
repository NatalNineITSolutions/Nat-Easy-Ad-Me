@if (moduleExists('Membership'))
    @if (membershipModuleExistsAndEnable('Membership'))
        @php
            $user = auth('web')->user();
        @endphp
        @if (empty($user->adsMembership))
            <div class="col-lg-12 mt-1">
                <div class="alert alert-warning d-flex justify-content-between">
                    <strong
                        style="font-size: 16px">{{ __('You must have be a distributor of our package to start listing ads.') }}</strong>
                    <a href="{{ getSlugFromReadingSetting('membership_plan_page') ? url('/' . getSlugFromReadingSetting('membership_plan_page')) : url('/membership') }}"
                        target="_self" class="btn btn-secondary radius-5">{{ __('View Membership Packages') }}</a>
                </div>
            </div>
        @else
            @if (!empty($user->adsMembership))
                <div class="col-lg-12 mt-1">
                    <div class="alert alert-info d-flex justify-content-between">
                        <p>{{ __('Your Current Distributor Package:') }}
                            <strong class="text-success"> {{ $user->adsMembership->membership->title }}</strong>
                            <!-- {{ __('Expire Date:') }}
                                <strong class="text-danger">
                                    {{ optional(auth('web')->user()->adsMembership)->expire_date ? \Carbon\Carbon::parse(auth('web')->user()->adsMembership->expire_date)->format('d M Y') : '' }}
                                </strong> -->
                        </p>
                    </div>
                </div>
            @endif
        @endif
    @endif
@endif
