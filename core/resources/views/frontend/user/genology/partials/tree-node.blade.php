<div class="mlm-tree full-width desktop-tree">
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
                                <div class="add-icon">
                                    <i class="fas fa-user-plus"></i>
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
        }

        .mobile-tree {
            display: none;
        }

        .new-style .box-shadow1 {
            background-color: #008081;
            border: none;
            border-radius: 0px;
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
        }
    </style>
@endsection

<script>
    function toggleAccordion(header) {
        header.classList.toggle('collapsed');
        const content = header.nextElementSibling;
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
</script>