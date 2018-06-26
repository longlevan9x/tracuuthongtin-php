<tr>
    <td class="a-center ">
        <input type="checkbox" name="table_records">
    </td>
    {{--<td class="a-center "><input type="checkbox" name="table_records"></td>--}}
    <td>{{$model->code}}</td>
    <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2">{{$model->name}}</td>
    <td>{{$model->group}}</td>
    <td>{{$model->test_day}}</td>
    <td>{{$model->examination}}</td>
    <td>{{$model->room}}</td>
    <td>{{$model->type}}</td>
    <td>{{$model->note}}</td>
    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">@component('admin.layouts.widget.labels.active'){{$model->is_active}} @endcomponent</td>
    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
        <a href="{{url('admin/department', [$model->id, 'edit'])}}"
           class="btn btn-sm btn-primary"><i class='fa fa-edit'></i></a>
        <a class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
    </td>
</tr>