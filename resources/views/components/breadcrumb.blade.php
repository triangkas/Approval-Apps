@props(['title'])
@props(['subtitle'])

@if ($title)
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }} @if(!empty($subtitle))<small class="sub-title">({{ $subtitle }})</small>@endif</h1>
            </div>
            <div class="col-sm-6 pt-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    {{ $slot }}
                </ol>
            </div>
            </div>
        </div>
    </section>
@endif