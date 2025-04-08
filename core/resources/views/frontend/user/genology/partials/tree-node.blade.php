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

{{-- Mobile/Tablet Accordion Layout --}}
{{-- Mobile/Tablet Accordion Layout --}}
<div class="mlm-tree full-width mobile-tree">
    <div class="mlm-node-card">
        <div class="node-header collapsed" onclick="toggleAccordion(this)">
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
            <div class="node-info" style="margin-left: 10px; text-align: left;">
                <strong>{{ $node->first_name ?? 'N/A' }}</strong><br>
                <small>ID: {{ $node->partner_id ?? 'N/A' }}</small><br>
                <small>BV (L): {{ $node->leftBV ?? 0 }} | BV (R): {{ $node->rightBV ?? 0 }}</small>
            </div>
            <i class="fas fa-chevron-down" style="margin-left:auto;"></i>
        </div>

        <div class="node-children" style="display: none;">
            {{-- Left Child --}}
            @if ($node->leftChild)
                @include('frontend.user.genology.partials.tree-node', ['node' => $node->leftChild])
            @else
                <div class="add-member-node">
                    <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                        <div class="add-icon"><i class="fas fa-user-plus"></i></div>
                    </a>
                </div>
            @endif

            {{-- Right Child --}}
            @if ($node->rightChild)
                @include('frontend.user.genology.partials.tree-node', ['node' => $node->rightChild])
            @else
                <div class="add-member-node">
                    <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                        <div class="add-icon"><i class="fas fa-user-plus"></i></div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- <div class="mlm-node-card">
    <div class="node-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#node-{{ $node->id }}">
        <div class="d-flex align-items-center">
            <div class="avatar-circle {{ $node->gender == 'female' ? 'female' : 'male' }} 
                {{ ($node->leftBV ?? 0) == 0 && ($node->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                <a href="{{ route('user.user.mlm.children', ['id' => $node->id]) }}">
                    @if($node->avatar)
                        <img src="{{ $node->avatar }}" alt="User Avatar">
                    @else
                        <img src="{{ $node->gender === 'female' ? asset('assets/uploads/media-uploader/girlavatart.jpg') : asset('assets/uploads/media-uploader/avatar.jpg') }}" alt="Default Avatar">
                    @endif
                </a>
            </div>
            <div class="ms-2">
                <div class="node-id">{{ $node->partner_id ?? 'N/A' }}</div>
                <div class="node-name">{{ $node->first_name ?? 'N/A' }}</div>
                <div class="bv-points">
                    <span>BV (L): <strong>{{ $node->leftBV ?? 0 }}</strong></span>
                    <span>BV (R): <strong>{{ $node->rightBV ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
        <i class="fas fa-chevron-down"></i>
    </div>

    <div id="node-{{ $node->id }}" class="collapse node-children">
        <ul class="children-list">
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
    </div>
</div> --}}

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

        .mobile-tree {
            display: none;
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

        @media (max-width: 992px) {
            .desktop-tree {
                display: none !important;
            }

            .mobile-tree {
                display: block;
            }

            .mlm-node-card {
                border: 2px solid #ffc107;
                border-radius: 10px;
                background: #008b8b;
                color: #fff;
                margin: 10px 0;
                padding: 10px;
            }

            .node-header {
                cursor: pointer;
                padding: 10px;
                background: #007373;
                border-radius: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .node-header i {
                transition: transform 0.3s ease;
            }

            .node-header.collapsed i {
                transform: rotate(-90deg);
            }

            .node-children {
                padding-left: 15px;
                margin-top: 10px;
                border-left: 2px solid rgba(255,255,255,0.3);
            }
        }

        @media (max-width: 768px) {
            .mobile-tree {
                padding: 0 10px;
                overflow-x: hidden; 
            }

            .mlm-node-card {
                margin: 10px 0;
                padding: 10px;
                border-radius: 10px;
                background: #008b8b;
                color: white;
                width: 100%; /* Ensure it doesn't exceed screen */
                box-sizing: border-box;
            }

            .node-header {
                flex-wrap: wrap; /* Allows image and info to wrap */
            }

            .avatar-circle {
                width: 50px;
                height: 50px;
                flex-shrink: 0;
            }

            .node-info {
                flex: 1;
                min-width: 0;
                margin-left: 10px;
                font-size: 14px;
            }

            .node-info small {
                font-size: 12px;
            }

            .node-header i {
                margin-left: auto;
            }
        }

        /* Mobile adjustments - ONLY padding reduction and scroll */
       
    </style>
    {{-- <style>
        .mlm-node-card {
            border: 2px solid #ffc107;
            border-radius: 10px;
            background: #008b8b;
            color: #fff;
            margin: 10px 0;
            padding: 10px;
        }

        .node-header {
            cursor: pointer;
            padding: 10px;
            border-radius: 10px;
        }

        .node-header:hover {
            background: #007373;
        }

        .node-header i {
            transition: transform 0.3s ease;
        }

        .node-header.collapsed i {
            transform: rotate(-90deg);
        }

        .children-list {
            list-style: none;
            padding-left: 0;
            margin-top: 10px;
        }

        .add-member-node {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .add-member-node .add-icon {
            font-size: 20px;
            padding: 10px;
            background: #ffc107;
            color: #008b8b;
            border-radius: 50%;
        }

        /* Responsive Accordion Behavior */
        @media (max-width: 992px) {
            .mlm-tree ul,
            .tree {
                padding-left: 0 !important;
            }

            .node-children {
                margin-left: 20px;
                border-left: 2px solid #ffffff33;
                padding-left: 10px;
            }
        }
    </style> --}}
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