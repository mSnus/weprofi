<div class="d-flex justify-content-center section-requests">

    <div class="newoffer-form mr-0">
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

        <div class="specs">
            <div class="h1">Мы - профи. Кто вам нужен?</div>
            
            <div class="search">
                <input type="text" name="spec_search" id="specSearch">
                <img src="/img/go.svg" alt="Search" width="32" height="32">
            </div>

            @php
                $specs = App\Models\Spec::with('users')->get()->all();
            @endphp
            @foreach ($specs as $spec)
                @php
                    $subspec_count = count($spec->subspecs);
                @endphp

                <div class="spec">
                    <a href="/spec/{{ $spec->id }}">{{ $spec->title }}</a>

                    @if ($subspec_count > 0)
                        @foreach ($spec->subspecs as $subspec)
                            <div class="subspec"><li><a href="/spec/{{ $spec->id}}/{{ $subspec->id}}">{{ $subspec->title }}</a></li></div>
                        @endforeach    
                    @endif
                    
                    
                </div>
            @endforeach
        </div>

    </div>
</div>
