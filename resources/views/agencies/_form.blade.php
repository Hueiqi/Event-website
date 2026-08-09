@props([
    'agency' => null,
])

<form method="POST" action="{{ $agency ? route('agencies.update', $agency) : route('agencies.store') }}" class="space-y-5">
    @csrf
    @if ($agency)
        @method('PUT')
    @endif

    @if ($errors->any())
        <x-ui.alert type="danger" title="Please fix the following">
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.alert>
    @endif

    <div>
        <label class="label" for="agency_name">Agency name</label>
        <input id="agency_name" type="text" name="agency_name" value="{{ old('agency_name', $agency->agency_name ?? '') }}" required class="input">
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="label" for="agency_code">Agency code</label>
            <input id="agency_code" type="text" name="agency_code" value="{{ old('agency_code', $agency->agency_code ?? '') }}" required placeholder="e.g. JDN, MOF" class="input">
        </div>
        <div>
            <label class="label" for="contact">Contact number</label>
            <input id="contact" type="text" name="contact" value="{{ old('contact', $agency->contact ?? '') }}" placeholder="e.g. 03-8000 0000" class="input">
        </div>
    </div>

    <div>
        <label class="label" for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $agency->email ?? '') }}" placeholder="admin@agency.gov.my" class="input">
    </div>

    <div>
        <label class="label" for="address">Address</label>
        <textarea id="address" name="address" rows="2" placeholder="Agency address..." class="input">{{ old('address', $agency->address ?? '') }}</textarea>
    </div>

    <div class="flex gap-3 border-t border-slate-100 pt-5">
        <button type="submit" class="btn btn-primary">{{ $agency ? 'Save changes' : 'Register agency' }}</button>
        <a href="{{ route('agencies.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
