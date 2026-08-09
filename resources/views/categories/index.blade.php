@extends('layouts.app')
@section('title', 'Manage Categories')

@section('content')
<x-ui.page-header title="Event categories" subtitle="Categories used to organise events." />

<div class="card mb-6 p-6">
    <h2 class="text-base font-bold text-slate-900">Add category</h2>
    <form method="POST" action="{{ route('categories.store') }}" class="mt-4 grid gap-4 sm:grid-cols-[1fr_1.5fr_auto]">
        @csrf
        <input type="text" name="category_name" placeholder="Category name" required class="input">
        <input type="text" name="description" placeholder="Description (optional)" class="input">
        <button type="submit" class="btn btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add
        </button>
    </form>
</div>

@if ($categories->isEmpty())
    <x-ui.empty title="No categories yet" message="Add a category above to start organising events." />
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">Name</th>
                        <th class="th hidden sm:table-cell">Description</th>
                        <th class="th">Events</th>
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($categories as $category)
                        <tr class="transition hover:bg-slate-50">
                            <td class="td font-semibold text-slate-900">{{ $category->category_name }}</td>
                            <td class="td hidden sm:table-cell text-slate-500">{{ $category->description ?? '—' }}</td>
                            <td class="td">
                                <x-ui.badge type="neutral">{{ $category->events_count }}</x-ui.badge>
                            </td>
                            <td class="td">
                                <div class="flex justify-end">
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                          onsubmit="return confirm('Delete this category?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
