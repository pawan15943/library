@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
       
        <div class="card card-default">
             <!-- Add Sub Menu Fields -->
            <div class="card-body">
                <form id="submit" action="{{ isset($menu) && $menu->id ? route('submenu.update', $menu->id) : route('submenu.store') }}" method="post">
                    @csrf
                    @if(isset($menu) && $menu->id)
                    @method('PUT')
                    @endif

                    @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif

                    <div class="row g-4">
                        @if(isset($menu) && $menu->id)
                        <input type="hidden" name="id" value="{{ $menu->id }}" id="menu_id">
                        @endif
                        <div class="col-lg-4">
                            <label for="class_name">Parent Menu<sup class="text-danger">*</sup></label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">Select Parent Menu</option>
                                @foreach($menu_list as $key => $value)
                                <option value="{{ $value->id }}" {{ isset($menu) && $menu->parent_id == $value->id ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>
                                @endforeach
                            </select>

                            @error('parent_id')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="class_name">Sub Menu Name<sup class="text-danger">*</sup></label>
                            <input type="text" id="name" name="name" value="{{ old('name', isset($menu) && $menu->name ? $menu->name : '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Sub menu name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="class_name">Sub Menu URL<sup class="text-danger">*</sup></label>
                            <input type="text" id="url" name="url" value="{{ old('url', isset($menu) && $menu->url ? $menu->url : '') }}" class="form-control @error('url') is-invalid @enderror" placeholder="Sub menu URL">
                            @error('url')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="class_name">Slug<sup class="text-danger">*</sup></label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', isset($menu) && $menu->slug ? $menu->slug : '') }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Sub menu slug">
                            @error('slug')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="class_name">Menu Icon<sup class="text-danger">*</sup></label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', isset($menu) && $menu->icon ? $menu->icon : '') }}" class="form-control @error('icon') is-invalid @enderror" placeholder="Sub menu icon">
                            @error('icon')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="class_name">Sub Menu Order<sup class="text-danger">*</sup></label>
                            <input type="text" id="order" name="order" value="{{ old('order', isset($menu) && $menu->order ? $menu->order : '') }}" class="form-control @error('order') is-invalid @enderror" placeholder="Sub menu order">
                            @error('order')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-block">{{ isset($menu) && $menu->id ? 'Update' : 'Add' }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->

            <!-- All Sub Menus Fields -->
            <div class="card-body">
                <h4 class="px-3 py-2">All Submenus List</h4>
                <div class="table-responsive tableRemove_scroll mt-2">
                    <table class="table table-hover dataTable m-0" id="datatable" style="display:table !important">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Sub Menu Name</th>
                                <th>Menu Name</th>
                                <th>Sub Menu Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $x = 1;
                            @endphp
                            @foreach($submenus as $key => $value)
                            <tr>
                                <td>{{ $x++ }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->menu_name }}</td>
                                <td>
                                    @if($value->status==1)
                                    <div class="text-success">Active</div>
                                    @else
                                    <div class="text-danger">Inactive</div>
                                    @endif
                                </td>
                                <td style="width: 20%">
                                    <ul class="actionables">
                                        <li>
                                            <a href="{{ route('submenu.edit', $value->id) }}" class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Menu">
                                                <i class="fas fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('submenu.destroy', $value->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <i class="fa fa-trash"></i>
                                            </form>
                                        </li>
                                    </ul>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end -->

        </div>
    </div>
</div>


@endsection