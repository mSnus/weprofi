<div class="d-flex justify-content-center section-requests">

    <div class="page-specs">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $specs = App\Http\Controllers\SpecController::getNonEmptySpecs();
        @endphp


        <div class="h1">Мы - профи. Кто вам нужен?</div>

        @include('components.search', ['region_options' => null])

        <div class="specs">
            @foreach ($specs as $spec)
                <div class="spec">
                    <a href="/spec/{{ $spec->id }}/0/">{{ $spec->title }}</a>
                </div>
            @endforeach
        </div>

    </div>
</div>
