@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Your Tasks</h1>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Title</th>
                <th class="py-2">Deadline</th>
                <th class="py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr class="border-t">
                <td class="py-2">{{ $task->title }}</td>
                <td class="py-2">{{ $task->deadline->format('Y-m-d') }}</td>
                <td class="py-2">
                    <select
                        class="border rounded p-1"
                        onchange="updateStatus({{ $task->id }}, this.value)"
                    >
                        @foreach(['Pending', 'In Progress', 'Completed'] as $status)
                        <option value="{{ $status }}" {{ $task->status === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function updateStatus(taskId, status) {
    fetch(`/tasks/${taskId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status })
    });
}
</script>
@endsection
