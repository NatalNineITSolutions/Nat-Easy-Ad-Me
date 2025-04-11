<div class="container-fluid px-1">
    <div class="mlm-tree">
        <ul class="tree">
            <li>
                <div class="node root-node">
                    <div class="avatar-circle {{ $node->gender == 'female' ? 'female' : 'male' }} 
                        {{ ($node->leftBV ?? 0) == 0 && ($node->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                        <a href="{{ route('user.user.mlm.children', ['id' => $node->id]) }}">
                            @if($node->avatar)
                                <img src="{{ $node->avatar }}" alt="User Avatar">
                            @else
                                <img src="{{ $node->gender === 'female' 
                                    ? asset('assets/uploads/media-uploader/girlavatart.jpg') 
                                    : asset('assets/uploads/media-uploader/avatar.jpg') }}"
                                    alt="Default Avatar">
                            @endif
                        </a>
                    </div>
                    <span class="node-id">{{ $node->partner_id ?? 'N/A' }}</span>
                    <span class="node-name">{{ $node->first_name ?? 'N/A' }}</span>
                    @if (!isset($isChild))
                        <div class="bv-points">
                            <span>BV (L): <strong>{{ $node->leftBV ?? 0 }}</strong></span>
                            <span>BV (R): <strong>{{ $node->rightBV ?? 0 }}</strong></span>
                        </div>
                    @endif
                </div>

                <ul>
                    <li>
                        @if ($node->leftChild)
                            @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild, 'isChild' => true])
                        @else
                            <div class="add-member-node">
                                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                                    <div class="add-icon"><i class="fas fa-user-plus"></i></div>
                                </a>
                            </div>
                        @endif
                    </li>
                    <li>
                        @if ($node->rightChild)
                            @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild, 'isChild' => true])
                        @else
                            <div class="add-member-node">
                                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                                    <div class="add-icon"><i class="fas fa-user-plus"></i></div>
                                </a>
                            </div>
                        @endif
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

@section('style')
<style>
    .mlm-tree {
        width: 100%;
        overflow-x: hidden;
        padding: 10px 0;
        background: #008081;
        border-radius: 8px;
    }

    .tree {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .tree ul {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
        list-style: none;
        width: 100%;
    }

    .tree li {
        position: relative;
        padding: 5px 2px;
        flex: 1 1 45%;
        min-width: 120px;
        max-width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tree li::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 2px;
        height: 10px;
        background: white;
    }

    .node {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #008081;
        padding: 8px;
        border-radius: 8px;
        width: 100%;
        max-width: 200px;
        box-shadow: 0 2px 5px rgba(255, 255, 255, 0.2);
    }

    .avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-circle.male {
        background: #1a237e;
        border: 3px solid #1a237e;
    }

    .avatar-circle.female {
        background: #d81b60;
        border: 3px solid #d81b60;
    }

    .avatar-circle.zero-bv {
        border: 3px solid #ff5252 !important;
        background: transparent !important;
    }

    .node-id,
    .node-name,
    .bv-points {
        color: white;
        font-size: 12px;
        text-align: center;
    }

    .bv-points {
        font-size: 11px;
        margin-top: 4px;
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }

    .add-icon {
        color: white;
        font-size: 24px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .mlm-tree {
            padding: 5px 0;
        }

        .tree ul {
            flex-direction: column;
            gap: 8px;
        }

        .tree li {
            flex: 1 1 100%;
            padding: 2px;
        }

        .node {
            max-width: 100%;
            padding: 5px;
        }

        .avatar-circle {
            width: 30px;
            height: 30px;
        }

        .node-id,
        .node-name {
            font-size: 10px;
        }

        .bv-points {
            font-size: 9px;
        }

        .add-icon {
            font-size: 18px;
        }
    }
</style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function calculateTreeDepth(node) {
            if (!node.children || node.children.length === 0) return 1;
            let maxDepth = 0;
            for (let i = 0; i < node.children.length; i++) {
                const depth = calculateTreeDepth(node.children[i]);
                if (depth > maxDepth) maxDepth = depth;
            }
            return maxDepth + 1;
        }

        const treeRoot = document.querySelector('.tree > ul > li');
        if (treeRoot) {
            const depth = calculateTreeDepth(treeRoot);
            const treeContainer = document.querySelector('.tree');
            const scaleClass = `tree-depth-${Math.min(depth, 7)}`;
            treeContainer.classList.add(scaleClass);
        }
    });
</script>

<!-- <script>
    function toggleAccordion(header) {
        header.classList.toggle('collapsed');
        const content = header.nextElementSibling;
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
</script> -->