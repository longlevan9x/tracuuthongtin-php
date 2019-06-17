<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 5/7/2018
 * Time: 10:56 PM
 */
$action     = request()->route()->getActionMethod();

$form_title = '';
switch ($action) {
	case "edit":
		$form_title = __('abilities.course.resource.edit');
		break;
	case "index":
		$form_title = __('abilities.course.resource.create');
		break;
}
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.layouts.title_form', ['title' => $form_title])
            <div class="x_content">
                {{ Form::model(isset($model) ? $model : null, [
                    'url' => \App\Http\Controllers\Admin\CourseController::getUrlAdmin(isset($model) ? $model->id : ''),
                    'files' => true,
                    'class' => 'form-horizontal form-label-left',
                    'id' => 'demo-form2',
                    'data-parsley-validate',
                    'method' => isset($model) ? 'put' : 'post'
                ]) }}
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">@lang('admin/common.label.code') <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {!! Form::number('code', $value = null,['required' => "required", 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'code']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('admin/common.name') <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {!! Form::text('name', $value = null,['required' => "required", 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'code']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="total_student" class="control-label col-md-3 col-sm-3 col-xs-12">@lang('repositories.course.total_student')</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {!! Form::number('total_student', $value = null,['required' => "required", 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'code']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('admin/common.label.is.active')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="">
                            <label>
                                {!! Form::hidden('is_active', $value = 0) !!}
                                {!! Form::checkbox('is_active', $value = 1,$value = null, ['class' => 'js-switch']) !!}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code"> @lang('abilities.department.name')
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        {!! Form::select('department_id', \App\Models\Department::pluck('name', 'id'), $value = null,['class' => 'form-control col-md-7 col-xs-12', 'id' => 'department_id']) !!}
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">@lang('admin.buttons.submit')</button>
                        <button class="btn btn-primary" type="reset">@lang('admin.buttons.reset')</button>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
