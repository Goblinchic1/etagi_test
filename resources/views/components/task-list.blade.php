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
