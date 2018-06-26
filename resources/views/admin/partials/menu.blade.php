<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 5/7/2018
 * Time: 4:05 PM
 */
?>

@push('menu_left')
    <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
            @include('admin.partials.profile_navigation')
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                        <li><a href="{{route(\App\Http\Controllers\Admin\DashboardController::getAdminRouteName('dashboard'))}}"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\DepartmentController::getAdminRouteName('index'))}}"><i class="fa fa-edit"></i> Department </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\CourseController::getAdminRouteName('index'))}}"><i class="fa fa-edit"></i> Course </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\AreaController::getAdminRouteName('index'))}}"><i class="fa fa-edit"></i> Area </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\SemesterController::getAdminRouteName())}}"><i class="fa fa-edit"></i> Semester </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\StudentController::getAdminRouteName())}}"><i class="fa fa-edit"></i> Student </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\ScheduleController::getAdminRouteName())}}"><i class="fa fa-edit"></i> Schedule </a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\ScheduleExamController::getAdminRouteName())}}"><i class="fa fa-edit"></i> Schedule Exam</a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\SyncController::getAdminRouteName('index'))}}"><i class="fa fa-edit"></i> Sync</a></li>
                        <li><a href="{{route(\App\Http\Controllers\Admin\SyncHistoryController::getAdminRouteName())}}"><i class="fa fa-edit"></i> Sync History</a></li>
                    </ul>
                </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
                <a data-toggle="tooltip" data-placement="top" title="Settings">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Lock">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
            </div>
            <!-- /menu footer buttons -->
        </div>
    </div>
    @include('admin.partials.top_nav')
@endpush
