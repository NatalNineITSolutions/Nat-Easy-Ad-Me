<!-- mlm-tree.blade.php -->
<div class="mlm-tree-container">
    <div class="mlm-tree full-width desktop-tree">
        <ul class="tree">
            <li>
                <div class="node root-node">
                    @php
                        $self = $node->self_purchased_bv ?? 0;
                        $left = $node->leftBV ?? 0;
                        $right = $node->rightBV ?? 0;
                        $ref = $node->referral_commission ?? 0;

                        // Determine status: red, yellow, green
                        $status = 'red';
                        if (
                            ($self >= 900 && $left >= 900 && $right >= 900) ||
                            ($ref >= 100 && $self >= 900)
                        ) {
                            $status = 'green';
                        } elseif ($left >= 900 && $right >= 900 && $self < 900) {
                            $status = 'yellow';
                        }
                    @endphp

                    <div class="avatar-circle
                                 {{ $node->gender == 'female' ? 'female' : 'male' }}
                                 status-{{ $status }}
                                 {{ ($node->leftBV ?? 0) == 0 && ($node->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                        <a href="{{ route('user.user.mlm.children', ['id' => $node->id]) }}">
                            @if($node->avatar)
                                <img src="{{ $node->avatar }}" alt="User Avatar">
                            @else
                                                    <img src="{{ $node->gender === 'female'
                                ? asset('assets/uploads/media-uploader/girlavatart.jpg')
                                : asset('assets/uploads/media-uploader/avatar.jpg') }}" alt="Default Avatar">
                            @endif
                        </a>
                    </div>

                    <span class="node-id">{{ $node->partner_id ?? 'N/A' }}</span>
                    <span class="node-name">{{ $node->first_name ?? 'N/A' }}</span>

                    {{-- Always show possible pairs for both root and child nodes --}}
                    <div class="possible-pairs">
                        <span>Pairs:
                            <strong>{{ $node->possible_pairs }}</strong>
                        </span>
                        <div class="bv-inside-pairs">
                            <span>BV (L): <strong>{{ $node->leftBV ?? 0 }}</strong></span>
                            <span>BV (R): <strong>{{ $node->rightBV ?? 0 }}</strong></span>
                        </div>
                    </div>

                    {{-- BV points remain only for root (optional) --}}
                    <!-- @if (!isset($isChild))
                        <div class="bv-points">
                            <span>BV (L): <strong>{{ $node->leftBV ?? 0 }}</strong></span>
                            <span>BV (R): <strong>{{ $node->rightBV ?? 0 }}</strong></span>
                        </div>
                    @endif -->
                </div>

                <ul>
                    <li>
                        @if ($node->leftChild)
                            @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild, 'isChild' => true])
                        @else
                            <div class="add-member-node">
                                <a
                                    href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                                    <div class="add-icon"><i class="fas fa-user-plus"></i></n>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </li>
                    <li>
                        @if ($node->rightChild)
                            @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild, 'isChild' => true])
                        @else
                            <div class="add-member-node">
                                <a
                                    href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
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
        .mlm-tree-container {
            width: 100%;
            height: auto;
            background: #008081;
            padding: 0;
            margin: 0;
        }

        .mlm-tree-scale-wrapper {
            width: 100%;
            /* position: relative; */
            background: #008081;
            padding: 10px 0;
        }

        .mlm-tree.full-width.desktop-tree {
            transform-origin: top center;
            transition: transform 0.3s ease;
            background: #008081;
            border-radius: 8px;
            width: 100%;
            /* Changed from calc(100% - 20px) */
            margin: 0;
            padding: 5px;
            /* Reduced from 10px */
        }

        .mlm-tree {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            width: 100% !important;
            max-width: 300vw;
            transform-origin: top center;
        }

        .full-width {
            background-color: red;
        }

        .mobile-tree {
            display: none;
        }

        .new-style .box-shadow1 {
            background-color: #008081;
            border: none;
            border-radius: 0px;
            height: 1000px;
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
            transform-origin: top center;
            transition: transform 0.3s ease;
        }

        .tree ul {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
            width: 100%;
            position: relative;
        }

        .tree li {
            position: relative;
            padding: 5px 2px;
            width: 100%;
            box-sizing: border-box;
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
            margin: 0 auto;
            max-width: 800px;
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
            transition: all 0.3s ease;
            position: relative;
        }

        .node-id,
        .node-name,
        .bv-points {
            color: white !important;
        }


        /* Male (default) styling */
        .avatar-circle.male {
            background: #1a237e;
            border: 3px solid #1a237e;
        }

        /* Female styling */
        .avatar-circle.female {
            background: #d81b60;
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

        .dis-title {
            font-size: 18px !important;
        }

        .possible-pairs {
            margin-top: 6px;
            padding: 6px 12px;
            background: #ffeb3b;
            border: 2px solid #fbc02d;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            animation: pulse-highlight 2s ease-in-out infinite;
            display: inline-block;
            text-align: left;
        }

        .possible-pairs span {
            color: #212121;
            font-weight: bold;
            font-size: 1rem;
        }

        .possible-pairs .bv-inside-pairs {
            margin-top: 4px;
            display: flex;
            gap: 12px;
        }

        .possible-pairs .bv-inside-pairs span {
            font-size: 0.9rem;
        }

        /* Status border colors */
        .avatar-circle.status-red {
            border: 5px solid red !important;
            background: transparent !important;
        }

        .avatar-circle.status-yellow {
            border: 5px solid yellow !important;
            background: transparent !important;
        }

        .avatar-circle.status-green {
            border: 5px solid green !important;
            background: transparent !important;
        }

        @keyframes pulse-highlight {

            0%,
            100% {
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            }

            50% {
                box-shadow: 0 0 16px rgba(0, 0, 0, 0.4);
            }
        }

        /* Dynamic scaling based on tree depth */
        .tree-depth-1 {
            transform: scale(1);
        }

        .tree-depth-2 {
            transform: scale(0.9);
        }

        .tree-depth-3 {
            transform: scale(0.8);
        }

        .tree-depth-4 {
            transform: scale(0.7);
        }

        .tree-depth-5 {
            transform: scale(0.6);
        }

        .tree-depth-6 {
            transform: scale(0.5);
        }

        .tree-depth-7 {
            transform: scale(0.4);
        }

        @media (max-width: 768px) {
            .mlm-tree {
                padding: 2px;
            }

            .tree {
                padding: 0;
            }

            .tree ul {
                padding: 0;
                margin: 0;
            }

            .tree li {
                position: relative;
                padding: 1px 0;
                width: 100%;
                margin: 0;
            }

            .tree li::before {
                content: '';
                position: absolute;
                top: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 1px;
                height: 8px;
                background: white;
                z-index: 1;
            }

            .node {
                padding: 2px;
                margin: 0 auto;
                width: 90%;
            }

            .avatar-circle {
                width: 20px;
                height: 20px;
                margin-bottom: 0;
                border-width: 1px;
            }

            .avatar-circle img {
                object-fit: fill;
                height: 18px;
            }

            .node-id,
            .node-name {
                font-size: 6px;
                line-height: 1;
                margin: 0;
            }

            .bv-points {
                font-size: 5px;
                display: flex;
                justify-content: center;
                width: 100%;
                gap: 10px;
            }

            .add-icon {
                font-size: 6px;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                top: 4px;
            }

            .tree>ul>li::before {
                display: none;
            }

            .tree ul ul li::before {
                height: 6px;
                top: -3px;
            }

            .dis-title {
                font-size: 12px !important;
            }

            .new-style .box-shadow1 {
                height: 250px;
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