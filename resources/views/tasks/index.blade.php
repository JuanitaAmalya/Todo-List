@extends('layouts.app')

@section('content')

<style>
    .btn-pink {
        background-color: #ff69b4;
        color: white;
        border: none;
    }

    .btn-pink:hover {
        background-color: #ff4da6;
        color: white;
    }
</style>
<div class="container mb-5">
    <h2 class="text-center mt-5 mb-4">To Do List Assignment!</h2>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="input-group">
            <input type="text" name="Title" class="form-control" placeholder="Masukkan tugas..." required minlength="3">
            <button type="submit" class="btn btn-pink">Add Task</button>
        </div>
    </form>

    <h4 class="mb-3">Daftar Tugas</h4>
    @forelse ($tasks as $task)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
               
                <div>
                    <div class="form-check"> <!--ini buat statusnya, udh atau bllm-->
                        @if ($task->Status)
                            <input
                                class="form-check-input"
                                type="checkbox"
                                checked>
                            <label class="form-check-label text-decoration-line-through">{{ $task->Title }}</label>
                            <span class="badge text-bg-success">Selesai</span>
                        @else
                            <form
                                action="{{ route('tasks.toggle', $task->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    onchange="this.form.submit()">
                                <label class="form-check-label">{{ $task->Title }}</label>
                            </form>
                        @endif
                    </div>
                </div>

                <button
                    type="button"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal{{ $task->id }}">Delete</button>
            </div>
        </div>

        <div
            class="modal fade"
            id="deleteModal{{ $task->id }}"
            tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Task?</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Are you sure you want to delete<strong>{{ $task->Title }}</strong>?</div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <form
                            action="{{ route('tasks.destroy', $task->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-secondary">Belum ada tugas.</div>
    @endforelse
</div>

@endsection