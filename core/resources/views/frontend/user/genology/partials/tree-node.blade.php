<div class="mlm-tree full-width">
    <ul class="tree">
        <li>
            <div class="node root-node">
                    <div class="avatar-circle {{ $node->gender == 'female' ? 'female' : 'male' }} 
                        {{ ($node->leftBV ?? 0) == 0 && ($node->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                        <a href="{{ route('user.user.mlm.children', ['id' => $node->id]) }}">
                            @if($node->avatar)
                                <img src="{{ $node->avatar }}" alt="User Avatar">
                            @else
                                <img src="{{ $node->gender === 'female' ? asset('assets/uploads/media-uploader/girlavatart.jpg') : asset('assets/uploads/media-uploader/avatar.jpg') }}" 
                                     alt="Default Avatar">
                            @endif
                        </a>
                    </div>
                <span class="node-id">{{ $node->partner_id ?? 'N/A' }}</span>
                <span class="node-name">{{ $node->first_name ?? 'N/A' }}</span>
                <div class="bv-points">
                    <span>BV (L): <strong>{{ $node->leftBV ?? 0 }}</strong></span>
                    <span>BV (R): <strong>{{ $node->rightBV ?? 0 }}</strong></span>
                </div>
            </div>

            <ul>
                <li>
                    @if ($node->leftChild)
                        @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild])
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
                <li>
                    @if ($node->rightChild)
                        @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild])
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
        </li>
    </ul>
</div>

@section('style')
    <style>
        .mlm-tree {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .full-width {
            background-color: #008081;
            overflow-x: auto;
        }

        .new-style .box-shadow1 {
            background-color: #008081;
            border: none;
        }

        .add-icon {
            color: white;
            font-size: 30px;
            position: relative;
            left: 6px;
        }

        .tree {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .tree ul {
            display: flex;
            justify-content: center;
            padding: 0;
            list-style: none;
            width: 100%;
        }

        .tree li {
            position: relative;
            padding: 10px 20px;
            width: 100%;
        }

        .tree li::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 30px;
            background: white;
        }

        .node {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #008081;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(255, 255, 255, 0.2);
        }

        .node-id,
        .node-name,
        .bv-points {
            color: white !important;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Male (default) styling */
        .avatar-circle.male {
            background: #1a237e; /* Blue color for male */
            border: 3px solid #1a237e;
        }

        /* Female styling */
        .avatar-circle.female {
            background: #d81b60; /* Pink color for female */
            border: 3px solid #d81b60;
        }

        /* Zero BV styling - this will override gender colors */
        .avatar-circle.zero-bv {
            border: 3px solid #ff5252 !important;
            background: transparent !important;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        /* Mobile adjustments - ONLY padding reduction and scroll */
        @media only screen and (max-width: 768px) {
            .mlm-tree {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
                padding: 20px 10px; /* Slightly reduce side padding */
            }

            .tree {
                min-width: 600px; /* Ensure tree maintains its width */
                width: auto;
                display: inline-block; /* Prevent vertical overflow */
            }

            /* Optional: Add scroll indicator for mobile */
            .mlm-tree::-webkit-scrollbar {
                height: 5px;
            }
            
            .mlm-tree::-webkit-scrollbar-thumb {
                background: rgba(255,255,255,0.3);
                border-radius: 5px;
            }
        }
    </style>
@endsection