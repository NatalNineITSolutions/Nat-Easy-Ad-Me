<div class="mlm-tree full-width">
    <ul class="tree">
        <li>
            <div class="node root-node">
                <div class="avatar-circle">
                    <img src="{{ $node->avatar ?? '/assets/uploads/media-uploader/avatar.jpg' }}" alt="User Avatar">
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
                    @if($node->leftChild)
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
                    @if($node->rightChild)
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
            background-color:  #008081;
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
            background: #1a237e;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            position: relative;
        }
    </style>
@endsection