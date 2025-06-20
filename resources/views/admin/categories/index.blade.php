@extends('layouts.app')

@section('title', 'Admin: Categories')
    
@section('content')
    <form action="{{ route('admin.categories.store') }}" method="post">
      @csrf

      <div class="row gx-2 mb-4">
        <div class="col-4">
          <input type="text" name="name" class="form-control" placeholder="Add a category..." autofocus>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
        {{-- ERROR --}}
        @error('name')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
      </div>
    </form>

    <div class="row">
      <div class="col-7">


    <table class="table table-hover align-middle bg-white border table-sm text-center text-secondary">
      <thead class="small table-warning text-secondary">
            <th>#</th>
            <th>NAME</th>
            <th>COUNT</th>
            <th>LAST UPDATED</th>
            <th></th>
      </thead>
      <tbody>
        @forelse ($all_categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td class="text-dark">{{ $category->name }}</td>
              <td>{{ $category->categoryPost->count() }}</td>
              <td>{{ $category->updated_at }}</td>
              <td>
                {{-- Edit Button --}}
                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}" title="Edit">
                  <i class="fa-solid fa-pen"></i>
                </button>

                {{-- Delete Button --}}
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}" title="Delete">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </td>
            </tr>
            {{-- include modal here --}}
            {{-- activity --}}
            @include('admin.categories.modals.action')
        @empty
            <tr>
              <td colspan="5" class="lead text-muted text-center">No categories found.</td>
            </tr>
        @endforelse
        <tr>
          <td></td>
          <td class="text-dark">
            Uncategorized
            <p class="xsmall mb-0 text-muted">Hidden posts are not included.</p>
          </td>
          <td>{{ $uncategorized_count }}</td>
          <td></td>
          <td></td>
        </tr>



        {{-- @foreach ($all_categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td>count</td>
              <td>{{ $category->updated_at }}</td>
              <td>
                <form action="#" method="post">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen text-warning"></i></button>
                </form>
                <form action="#" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can text-danger"></i></button>
                </form>
              </td> --}}
              {{-- <td>
                @if (Auth::user()->id !== $user->id)
                  <div class="dropdown">
                    <button class="btn btn-sm" data-bs-toggle="dropdown">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>

                    <div class="dropdown-menu">
                      @if ($user->trashed())
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                          <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                        </button>
                      @else
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                          <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                        </button>
                      @endif
                    </div>
                  </div>
                  @include('admin.users.modals.status')
                @endif
              </td> --}}
            {{-- </tr>
        @endforeach --}}
      </tbody>
    </table>


    </div>
    </div>




    <div class="d-flex justify-content-center">
       {{ $all_categories->links() }}
    </div>
   
@endsection