<li>
    <div class="node">
        <span class="node-name">{{ $node->first_name ?? 'N/A' }}</span>
        <span class="node-id">{{ $node->partner_id ?? 'N/A' }}</span>
        <div class="bv-points">
            <span> BV : <strong>{{ $node->userBvs->sum('bv_points') }}</strong> </span>
        </div>
    </div>
    <ul>
        <!-- Left Child -->
        <li>
            @if($node->leftChild)
                @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild])
            @else
                <div class="node placeholder">
                    <a href="{{ route('mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                        {{ __('Add New Member') }}
                    </a>
                </div>
            @endif
        </li>
        <!-- Right Child -->
        <li>
            @if($node->rightChild)
                @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild])
            @else
                <div class="node placeholder">
                    <a href="{{ route('mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                        {{ __('Add New Member') }}
                    </a>
                </div>
            @endif
        </li>
    </ul>
</li>
