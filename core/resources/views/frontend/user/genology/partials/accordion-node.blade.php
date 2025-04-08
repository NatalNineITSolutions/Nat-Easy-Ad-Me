<div class="accordion-item">
    <h2 class="accordion-header" id="heading-{{ $node->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $node->id }}" aria-expanded="false" aria-controls="collapse-{{ $node->id }}">
            <div class="d-flex align-items-center">
                <div class="avatar-circle {{ $node->gender == 'female' ? 'female' : 'male' }} {{ ($node->leftBV ?? 0) == 0 && ($node->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                    @if($node->avatar)
                        <img src="{{ $node->avatar }}" alt="User Avatar">
                    @else
                        <img src="{{ $node->gender === 'female' ? asset('assets/uploads/media-uploader/girlavatart.jpg') : asset('assets/uploads/media-uploader/avatar.jpg') }}" alt="Default Avatar">
                    @endif
                </div>
                <div class="ms-3 text-start">
                    <div class="fw-bold text-dark">{{ $node->partner_id ?? 'N/A' }} - {{ $node->first_name ?? 'N/A' }}</div>
                    <div class="small text-muted">BV (L): {{ $node->leftBV ?? 0 }} | BV (R): {{ $node->rightBV ?? 0 }}</div>
                </div>
            </div>
        </button>
    </h2>
    <div id="collapse-{{ $node->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $node->id }}" data-bs-parent="#mlmAccordion">
        <div class="accordion-body ps-5">
            @if($node->leftChild)
                @include('frontend.user.genology.partials.accordion-node', ['node' => $node->leftChild])
            @else
                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'left']) }}">
                    <i class="fas fa-user-plus text-primary me-2"></i> Add Left Member
                </a>
            @endif

            <hr>

            @if($node->rightChild)
                @include('frontend.user.genology.partials.accordion-node', ['node' => $node->rightChild])
            @else
                <a href="{{ route('user.mlm.addNewMember', ['sponsor' => $node->id, 'position' => 'right']) }}">
                    <i class="fas fa-user-plus text-primary me-2"></i> Add Right Member
                </a>
            @endif
        </div>
    </div>
</div>

@section('style')
    <style>
        /* Show/Hide based on screen */
.desktop-view {
    display: block;
}
.mobile-view {
    display: none;
}

@media (max-width: 991px) {
    .desktop-view {
        display: none !important;
    }
    .mobile-view {
        display: block !important;
    }
}

/* Accordion adjustments */
.tree-accordion .accordion-button {
    background-color: #f0f0f0;
    border: none;
}

.avatar-circle img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}

    </style>
@endsection