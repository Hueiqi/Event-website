@props([
    'event' => null,
    'categories' => [],
])

<form method="POST" action="{{ $event ? route('events.update', $event) : route('events.store') }}" class="space-y-5">
    @csrf
    @if ($event)
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
        <label class="label" for="title">Event title</label>
        <input id="title" type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required
               placeholder="e.g. Digital Government Conference 2026" class="input">
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="label" for="category_id">Category</label>
            <select id="category_id" name="category_id" required class="input">
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}"
                        @selected(old('category_id', $event->category_id ?? '') == $category->category_id)>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label" for="status">Status</label>
            <select id="status" name="status" class="input">
                @foreach (['draft', 'open', 'closed', 'cancelled', 'completed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $event->status ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="label" for="description">Description</label>
        <textarea id="description" name="description" rows="4" placeholder="Brief description of the event..."
                  class="input">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        <div>
            <label class="label" for="date">Date</label>
            <input id="date" type="date" name="date" value="{{ old('date', $event ? \Carbon\Carbon::parse($event->date)->format('Y-m-d') : '') }}" required class="input">
        </div>
        <div>
            <label class="label" for="time">Time</label>
            <input id="time" type="time" name="time" value="{{ old('time', $event->time ?? '') }}" required class="input">
        </div>
        <div>
            <label class="label" for="capacity">Capacity</label>
            <input id="capacity" type="number" name="capacity" min="1" value="{{ old('capacity', $event->capacity ?? '') }}" required class="input">
        </div>
    </div>

    <div>
        <label class="label" for="venue">Venue</label>
        <input id="venue" type="text" name="venue" value="{{ old('venue', $event->venue ?? '') }}" required
               placeholder="e.g. Level 3, Dewan Seri Gemilang, Putrajaya" class="input">
    </div>

    <div class="flex gap-3 border-t border-slate-100 pt-5">
        <button type="submit" class="btn btn-primary">
            {{ $event ? 'Update event' : 'Publish event' }}
        </button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
