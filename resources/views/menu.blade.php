@extends('layouts.admin')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
   <!-- Page Heading -->
<div class="card shadow mb-4 py-4">
    <div class="col-lg-12">
        <form id="submit" action="{{ isset($menu) && $menu->id ? route('menu.update', $menu->id) : route('menu.store') }}" method="post">
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
              
                <div class="col-lg-5">
                    <input type="text" id="name" name="name" value="{{ old('name', isset($menu) && $menu->name ? $menu->name : '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Menu Name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-lg-5">
                    <input type="text" id="url" name="url" value="{{ old('url', isset($menu) && $menu->url ? $menu->url : '') }}" class="form-control @error('url') is-invalid @enderror" placeholder="Menu URL">
                    @error('url')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-lg-5">
                    <input type="text" id="slug" name="slug" value="{{ old('slug', isset($menu) && $menu->slug ? $menu->slug : '') }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Menu Slug">
                    @error('slug')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-lg-5">
                    <input type="text" id="icon" name="icon" value="{{ old('icon', isset($menu) && $menu->icon ? $menu->icon : '') }}" class="form-control @error('icon') is-invalid @enderror" placeholder="Menu Icon">
                    @error('icon')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-lg-5">
                    <input type="text" id="order" name="order" value="{{ old('order', isset($menu) && $menu->order ? $menu->order : '') }}" class="form-control @error('order') is-invalid @enderror" placeholder="Menu Order">
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
</div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Menu Id</th>
                            <th>Menu Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @php
                            $x = 1;
                        @endphp
                        @foreach($menus as $key => $value)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->is_active ? 'Active' : 'Inactive' }}</td>
                            <td style="width: 20%">
                                <a href="{{ route('menu.edit', $value->id) }}" class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Menu">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('menu.destroy', $value->id) }}" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded" title="Delete Menu">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
