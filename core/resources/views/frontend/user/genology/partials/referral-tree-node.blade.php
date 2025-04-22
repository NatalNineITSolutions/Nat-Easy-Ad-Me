@if (!empty($node['user']))
    <div class="tree-node {{ $isRoot ?? false ? 'root-user' : '' }}">
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
            </div>
        </div>
    </div>
@endif
