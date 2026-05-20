@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Manage Categories</h1>

<div class="bg-white p-6 rounded-lg shadow mb-6">
    <form action="{{ route('admin.category.add') }}" method="POST" class="flex gap-4">
        @csrf
        <input type="text" name="name" placeholder="New Category Name" required class="border p-3 rounded-lg flex-1">
        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold">Add Category</button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-coffee-900 text-white">
            <tr>
                <th class="p-4">ID</th>
                <th class="p-4">Category Name</th>
                <th class="p-4">Products Count</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-b">
                <td class="p-4">#{{ $category->id }}</td>
                <td class="p-4 font-bold">{{ $category->name }}</td>
                <td class="p-4">{{ $category->products->count() }} items</td>
                <td class="p-4">
                    <form action="{{ route('admin.category.delete', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm font-bold hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection