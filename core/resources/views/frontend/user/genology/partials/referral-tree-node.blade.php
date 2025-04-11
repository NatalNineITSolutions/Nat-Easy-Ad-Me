@if (!empty($node['user']))
    <div class="tree-node">
        <div class="node-card {{ $node['user']->membership ? 'paid' : 'free' }}">
            @php
                $avatar = asset('default-avatar.png');
                if ($node['user']->gender === 'male') {
                    $avatar = asset('assets/uploads/media-uploader/avatar.jpg');
                } elseif ($node['user']->gender === 'female') {
                    $avatar = asset('assets/uploads/media-uploader/girlavatart.jpg');
                }
            @endphp
            <img src="{{ $avatar }}" class="user-avatar" alt="User Image">
            <div class="node-details">
                <span><strong>{{ $node['user']->full_name }}</strong></span>
                <span>ID: {{ $node['user']->partner_id }}</span>
                <!-- <span>{{ $node['user']->user_city->city ?? 'N/A' }}</span>
                <span>{{ $node['user']->membership ? 'Paid User' : 'Free User' }}</span> -->
            </div>
        </div>

        @if (!empty($node['children']) && count($node['children']) > 0)
            <div class="children-wrapper">
                @foreach ($node['children'] as $child)
                    @include('frontend.user.genology.partials.referral-tree-node', ['node' => ['user' => $child]])
                @endforeach
            </div>
        @endif
    </div>
@endif
