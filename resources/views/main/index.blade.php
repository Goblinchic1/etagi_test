@extends('main.layout')
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12 row">
                    <div class="col-5 col-md-3">
                        <label for="expiration_date_sort">По дате завершения</label>
                        <select id="expiration_date_sort" name="expiration_date" class="form-select">
                            <option value="today">На сегодня</option>
                            <option value="week">На неделю</option>
                            <option value="future">На будущее</option>
                        </select>
                    </div>
                    @if(isset($oResponsible[0]))
                        <div class="col-5 col-md-3">
                            <label for="responsible_sort">По ответственным</label>
                            <select id="responsible_sort" name="responsible" class="form-select">
                                @foreach($oResponsible as $oUserResponsible)
                                    <option value="{{ $oUserResponsible->email }}">{{ $oUserResponsible->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-5 col-md-3">
                        <label for="date_sort">Без группировок</label>
                        <input class="form-control" id="date_sort" type="button" name="date_sort"
                               value="Без группировок">
                    </div>
                    <div class="col-5 col-md-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTask">Добавить
                            задачу
                        </button>
                    </div>
                </div>
                @if(isset($oTasks))
                    <div class="table-responsive" id="tasks_table">
                        <table class="table">
                            <thead class="table-light">
                            <tr>
                                <th>Заголовок</th>
                                <th>Приоритет</th>
                                <th>Статус</th>
                                <th>Дата окончания</th>
                                <th>Ответственный</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($oTasks as $oTask)
                                <tr data-id="{{ $oTask->id }}">
                                    <td class="@if($oTask->status == 'complete') text-success
                                            @elseif(strtotime($oTask->expiration_date) < strtotime(date('Y-m-d H:i:s'))) text-danger
                                            @else text-secondary @endif">
                                        {{ $oTask->title }}
                                    </td>
                                    <td>{{ $oTask->priority }}</td>
                                    <td>
                                        <select class="form-select" name="status">
                                            <option class="form-control" value="to fulfillment"
                                                    @if($oTask->status == 'to fulfillment') selected @endif>К выполнению
                                            </option>
                                            <option class="form-control" value="performed"
                                                    @if($oTask->status == 'performed') selected @endif>Выполняется
                                            </option>
                                            <option class="form-control" value="complete"
                                                    @if($oTask->status == 'complete') selected @endif>Выполнена
                                            </option>
                                            <option class="form-control" value="canceled"
                                                    @if($oTask->status == 'canceled') selected @endif>Отменена
                                            </option>
                                        </select>
                                    </td>
                                    <td>{{ $oTask->expiration_date }}</td>
                                    <td>{{ $oTask->responsible }}</td>
                                    <td>
                                        <button class="btn btn-primary update_task" data-bs-toggle="modal"
                                                @if($oTask->creator !== auth()->user()->email) disabled
                                                @endif data-bs-target="#updateTask">
                                            Обновить задачу
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="createTask" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskLabel">Создать задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tasks.store') }}" id="createTaskForm" class="form-control" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="col-form-label" for="createTaskTitle">Заголовок</label>
                            <input id="createTaskTitle" class="form-control" type="text" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="createTaskDesc">Описание</label>
                            <input id="createTaskDesc" class="form-control" type="text" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="createTaskDate">Дата окончания</label>
                            <input id="createTaskDate" class="form-control" type="datetime-local" name="expiration_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="createTaskPriority">Приоритет</label>
                            <select id="createTaskPriority" class="form-select" name="priority">
                                <option class="form-control" value="high">Высокий</option>
                                <option class="form-control" value="middle" selected>Средний</option>
                                <option class="form-control" value="low">Низкий</option>
                            </select>
                        </div>
                        @if(isset($oResponsible[0]))
                            <div class="mb-3">
                                <label for="createTaskResponsible">Ответственный</label>
                                <select id="createTaskResponsible" name="responsible" class="form-select">
                                    <option class="form-control" value="null">Без ответственного</option>
                                    @foreach($oResponsible as $oUserResponsible)
                                        <option class="form-control"
                                                value="{{ $oUserResponsible->email }}">{{ $oUserResponsible->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary col-12">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateTask" tabindex="-1" aria-labelledby="updateTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTaskLabel">Обновить задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="updateTaskForm" class="form-control" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="col-form-label" for="updateTaskTitle">Заголовок</label>
                            <input id="updateTaskTitle" class="form-control" type="text" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="updateTaskDesc">Описание</label>
                            <input id="updateTaskDesc" class="form-control" type="text" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="updateTaskDate">Дата окончания</label>
                            <input id="updateTaskDate" class="form-control" type="datetime-local" name="expiration_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="updateTaskPriority">Приоритет</label>
                            <select id="updateTaskPriority" class="form-select" name="priority">
                                <option class="form-control" value="high">Высокий</option>
                                <option class="form-control" value="middle">Средний</option>
                                <option class="form-control" value="low">Низкий</option>
                            </select>
                        </div>
                        @if(isset($oResponsible[0]))
                            <div class="mb-3">
                                <label for="updateTaskResponsible">Ответственный</label>
                                <select id="updateTaskResponsible" name="responsible" class="form-select">
                                    <option class="form-control" value="null">Без ответственного</option>
                                    @foreach($oResponsible as $oUserResponsible)
                                        <option class="form-control" value="{{ $oUserResponsible->email }}">
                                            {{ $oUserResponsible->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary col-12">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
