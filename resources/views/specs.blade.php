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


        <div class="h1">Мы - профи. Кто вам нужен?</div>

        @include('components.search')

        <div class="specs">
            @php
                $specs = App\Models\Spec::get()->all();
            @endphp
            @foreach ($specs as $spec)
                <div class="spec">
                    <a href="/spec/{{ $spec->id }}">{{ $spec->title }}</a>
                </div>
            @endforeach
        </div>

    </div>
</div>
