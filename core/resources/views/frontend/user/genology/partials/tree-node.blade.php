<div class="node {{ isset($position) && $position == 'left' ? 'left-node' : 'right-node' }}">
    <div class="avatar-circle {{ $node->is_active ? '' : 'empty' }}">
        <div class="avatar-inner"></div>
    </div>
    <span class="node-id">{{ $node->partner_id ?? 'N/A' }}</span>
    <span class="node-name">{{ $node->first_name ?? 'N/A' }}</span>
    
    <!-- BV Points for Every User -->
    @if(isset($node->leftBV) || isset($node->rightBV))
    <div class="bv-points">
        @if(isset($node->leftBV))
            <span>BV (L): <strong>{{ $node->leftBV }}</strong></span>
        @endif
        @if(isset($node->rightBV))
            <span>BV (R): <strong>{{ $node->rightBV }}</strong></span>
        @endif
    </div>
    @endif
</div>

@if(isset($node->leftChild) || isset($node->rightChild))
<ul>
    <!-- Left Child -->
    <li class="left-branch">
        @if($node->leftChild)
            @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild, 'position' => 'left'])
        @else
            <div class="add-member-node">
                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                    <div class="add-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </a>
            </div>
        @endif
    </li>

    <!-- Right Child -->
    <li class="right-branch">
        @if($node->rightChild)
            @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild, 'position' => 'right'])
        @else
            <div class="add-member-node">
                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                    <div class="add-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </a>
            </div>
        @endif
    </li>
</ul>
@else
<ul>
    <!-- Left Slot (Empty) -->
    <li class="left-branch">
        <div class="add-member-node">
            <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                <div class="add-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </a>
        </div>
    </li>

    <!-- Right Slot (Empty) -->
    <li class="right-branch">
        <div class="add-member-node">
            <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                <div class="add-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </a>
        </div>
    </li>
</ul>
@endif