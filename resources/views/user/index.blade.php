<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("User's List") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="btn-wrapper">
                    <a class="info" href="{{route('users.create')}}">Add User</a>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('status') && session('message'))
                        <div class="{{ session('status') }}">
                            {{ session('message') }}
                        </div>
                    @endif
                  <table>
                    <thead>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        @foreach ($response as $user )
                       <tr>
                        <td>{{$i+=1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->mobile_no}}</td>
                        <td class="action-wrapper">
                            <a class="" href="{{route('users.show',$user->id)}}">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            
                                <button type="submit" class="" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                            {{-- <a class="" href="{{route('users.show',$user->id)}}">Reset Password</a> --}}

                        </td>
                       </tr>
                        @endforeach
                        
                    </tbody>
                  </table>
                  <div class="pagination">
                {{$response->links()}}

                  </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
