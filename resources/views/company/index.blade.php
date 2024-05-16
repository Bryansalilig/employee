@extends('layout.main')
@section('style')
<link href="<?= URL::to('public/pages/mailbox.css')?>" rel="stylesheet" />
@endsection
@section('content')
<div class="page-heading">
    <h1 class="page-title">Company Policy</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Mail View</li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div>
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Attendance</h4>
                            <span>attendance.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/attendance.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div>
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Company Directives</h4>
                            <span>directives.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/directives.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="text-center">
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Dress Code</h4>
                            <span>dresscode.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/dresscode.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="text-center">
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">eCodes</h4>
                            <span>ecodes.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/ecodes.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="text-center">
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Waste Segregation</h4>
                            <span>segregation.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/segregation.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3">
                        <div class="text-center">
                            <img class="card-img-top file-image" src="<?= URL::to('public/img/file.png') ?>" height="200px">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Loitering After Office Hours</h4>
                            <span>officehours.pdf</span>
                            <a class="btn btn-default btn-xs float-right" href="javascript:;"><i class="fa fa-download"></i></a>
                            <a class="btn btn-default btn-xs float-right" href="<?= URL::to('public/attachment/officehours.pdf') ?>" target="_blank"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
